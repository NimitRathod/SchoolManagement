<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementsRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementsController extends Controller
{
    public $modules = [];
    public $announcedBy = [];
    public function __construct()
    {
        $this->modules = [
            'title' => 'Announcement',
            'folder_path' => 'announcement',
            'route' => 'announcements',
            'table_name' => (new Announcement())->getTable(),
            'permisstion_prefix' => 'announcements',
        ];
        
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-list', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-delete', ['only' => ['destroy']]);
        
        $this->announcedBy = ['teachers' => "Teacher", 'students' => "Student", "parents" => "Parent"];
        View::share('announcedBy', $this->announcedBy);
    }
    
    public function index(Request $request)
    {
        
        try {
            $data = [];
            $modules = $this->modules;
            
            View::share('modules', $modules);
            
            if ($request->ajax()) {
                
                $editPermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-edit')) ? true : false;
                $deletePermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-delete')) ? true : false;
                
                $login_user_role = Helper::getLoginUserRole();
                
                $data = new Announcement();
                if(in_array($login_user_role, ['teachers', 'students', 'parents'])){
                    // $role = Role::where('name', $login_user_role)->first();
                    $data = $data->where(function($query) use ($login_user_role){
                        $query->where("target", $login_user_role);
                        $query->orWhere("created_by", auth()->id());
                    });
                    // $data = $data->where("target", $login_user_role);
                }
                $data = $data->orderBy('id','DESC');
                // return $data;
                
                return Datatables::of($data)
                ->addIndexColumn()->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('title', 'like',"%".$request->search."%");
                        // $query->orWhere('email', 'like',"%".$request->search."%");
                    }
                    if ($request->has('status') && !empty($request->status)) {
                        $query->where('status', $request->status);
                    }
                })
                ->editColumn('created_at', function($record){
                    return \Carbon\Carbon::parse($record?->created_at)->format('d M Y H:i A');
                })
                ->editColumn('status', function($record){
                    return ucfirst($record->status);
                })
                ->editColumn('target', function($record){
                    return ucfirst($record->target);
                })
                ->addColumn('action', function($row) use ($modules,$editPermisstion, $deletePermisstion){
                    
                    $btn = '';
                    if($editPermisstion){
                        $btn .= '<a href="'.route($modules["route"].".edit",[$row["id"]]).'" class="btn btn-info btn-icon"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }
                    if($deletePermisstion || Auth::id() == $row->created_by){
                        $btn .= '<a href="javascript:void(0)" data-id="'.$row->id .'" data-did="'.route($modules["route"].".destroy",[$row["id"]]).'" class="btn btn-danger btn-icon deletebutton"><i class="fa-solid fa-trash"></i></i></a>';
                    }
                    if($btn == ''){
                        $btn = '-';
                    }
                    return $btn;
                    
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            
            return view('admin.templates.'.$modules['folder_path'].'.index',compact('data'));
        } catch (\Exception $e) {
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage())->withInput();
        }
    }
    
    public function create()
    {
        try {
            $modules = $this->modules;
            $modules['title'] = 'Create '.$modules['title'];
            View::share('modules', $modules);
            
            $login_user_role = Helper::getLoginUserRole();
            if(in_array($login_user_role, ['teachers'])){
                unset($this->announcedBy['teachers']);
            }
            // return $this->announcedBy;
            View::share('announcedBy', $this->announcedBy);

            return view('admin.templates.'.$modules['folder_path'].'.form');
            
        } catch (\Exception $e) {
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage())->withInput();
        }
    }
    
    public function store(AnnouncementsRequest $request)
    {
        DB::beginTransaction();
        try {            
            $modules = $this->modules;
            // return $modules['role']?->id;
            foreach ($request->announced_by as $value) {
                $role = Role::where('name', $value)->first();
                if($role && $role?->id){
                    $announcement = Announcement::create([
                        'title' => $request->title,
                        'content' => $request->content,
                        'target' => $value,
                        'role_id' => $role?->id,
                        'created_by' => auth()->id(),
                    ]);
                }

            }
            // return $request->all();
            
            DB::commit();

            return Redirect::route($modules['route'].'.index')->with('success', $modules['title'].' create successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage())->withInput();
        }
        return Redirect::back()->withErrors('Something went wrong')->withInput();
    }
    
    /**
    * Display the specified resource.
    */
    public function show(string $id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, string $id)
    {
        //
    }
    
    public function destroy(Request $request, string $id)
    {
        try{
            $modules = $this->modules;
            $dataDelete = Announcement::findOrFail($id);
            if($dataDelete){
                if($request->ajax()){
                    if($dataDelete->delete()){
                        // return Redirect::route($modules['route'].'.index');
                        return true;
                    }
                    return false;
                }
                if($dataDelete->delete()){
                    return Redirect::route($modules['route'].'.index');
                }
            }
            return Redirect::back()->withErrors('something went wrong please try again later');
        }
        catch(\Exception $e) {
            DB::rollBack();
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage());
        }
    }
}

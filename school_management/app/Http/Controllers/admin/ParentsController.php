<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParentsRequest;
use App\Models\Parents;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class ParentsController extends Controller
{
    public $modules = [];
    
    public function __construct()
    {
        $this->modules = [
            'title' => 'Parents',
            'folder_path' => 'parent',
            'route' => 'parents',
            'table_name' => (new Parents())->getTable(),
            'permisstion_prefix' => 'parents',
            'role' => Role::where('name', 'parents')->first(),
        ];
        
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-list', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-delete', ['only' => ['destroy']]);
        
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

                $data = Parents::with(['roles']);
                $data = $data->whereHas("roles", function($q) use ($modules){
                    $q->whereIn("name", [$modules['role']?->name]);
                });
                $data = $data->orderBy('id','DESC');
                // return $data;
                
                return Datatables::of($data)
                ->addIndexColumn()->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('name', 'like',"%".$request->search."%");
                        // $query->orWhere('email', 'like',"%".$request->search."%");
                    }
                    if ($request->has('status') && !empty($request->status)) {
                        $query->where('status', $request->status);
                    }
                    if ($request->has('role') && !empty($request->role)) {
                        $search_role = $request->role;
                        $query->whereHas("roles", function($q) use ($search_role){
                            return $q->where('id', $search_role);
                        });
                    }
                })
                ->editColumn('status', function($record){
                    return ucfirst($record->status);
                })
                ->addColumn('role_name', function($record){
                    return ucfirst($record?->roles?->first()?->name);
                })
                ->addColumn('action', function($row) use ($modules,$editPermisstion, $deletePermisstion){
                    
                    $btn = '';
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    if($editPermisstion){
                        $btn .= '<a href="'.route($modules["route"].".edit",[$row["id"]]).'" class="btn btn-info btn-icon"><i class="fa-solid fa-pen-to-square"></i></a>';
                    }
                    if($deletePermisstion){
                        $btn .= '<a href="javascript:void(0)" data-id="'.$row->id .'" data-did="'.route($modules["route"].".destroy",[$row["id"]]).'" class="btn btn-danger btn-icon deletebutton"><i class="fa-solid fa-trash"></i></i></a>';
                    }
                    // $btn .= '<a href="javascript:void(0)" class="btn btn-primary btn-icon"><i class="fa-solid fa-key"></i></a>';
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
            //throw $th;
        }
    }
    
    public function create()
    {
        try {
            $modules = $this->modules;
            $modules['title'] = 'Create '.$modules['title'];
            View::share('modules', $modules);
            
            return view('admin.templates.'.$modules['folder_path'].'.form');
            
        } catch (\Exception $e) {
            return $e->getMessage();
            //throw $th;
        }
    }

    public function store(ParentsRequest $request)
    {
        DB::beginTransaction();
        try {            
            $modules = $this->modules;
            // return $modules['role']?->id;

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            
            // dd($request->all(),$input);
            $user = Parents::create($input);
            // dd($user, $modules);

            $user->assignRole($modules['role']?->name);
            
            $user = User::findOrFail($user?->id);
            $user->assignRole($modules['role']?->name);
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

    public function edit(string $id)
    {
        try{
            $modules = $this->modules;
            $modules['title'] = 'Edit '.$modules['title'];
            $edit = Parents::with('roles')->findOrFail($id);
            
            // return $edit->roles->pluck('id')->first();
            return view('admin.templates.' . $modules['folder_path'] . '.form', compact('modules','edit'));
        }
        catch(\Exception $e) {
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage());
        }
    }
    
    public function update(ParentsRequest $request, string $id)
    {
        DB::beginTransaction();
        try{
            $modules = $this->modules;
            $updateData = $request->all();
            
            unset($updateData['password']);
            
            $user = Parents::findOrFail($id);
            if($user){
                $user->name = $request?->name;
                $user->email = $request?->email;
                if($request->password && !empty($request->password)){
                    $updateData['password'] = Hash::make($request->password);
                }
                $user->status = $request?->status;
                $user->save();

                /*
                $user->syncRoles($modules['role']?->name);

                $user = User::findOrFail($id);
                $user->syncRoles($modules['role']?->name);
                */

                // $user->syncRoles($request->input('role'));

                DB::commit();
                
                return Redirect::route($modules['route'].'.index')->withSuccess($modules['title'].' update successfully');
            }
            return Redirect::back()->withErrors('something went wrong please try again later')->withInput();
        }
        catch(\Exception $e) {
            DB::rollBack();
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage());
        }
        
    }
    
    public function destroy(Request $request, string $id)
    {
        try{
            $modules = $this->modules;
            $dataDelete = Parents::findOrFail($id);
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

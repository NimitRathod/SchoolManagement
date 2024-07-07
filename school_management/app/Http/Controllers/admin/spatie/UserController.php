<?php

namespace App\Http\Controllers\admin\spatie;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    
    public $modules = [];
    
    public function __construct()
    {
        $this->modules = [
            'title' => 'Users',
            'folder_path' => 'spatie.users',
            'route' => 'users',
            'table_name' => (new User())->getTable(),
            'permisstion_prefix' => 'users',
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

            $roles = Role::get();
            View::share('roles', $roles);

            if ($request->ajax()) {
                
                $editPermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-edit')) ? true : false;
                $deletePermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-delete')) ? true : false;
                
                $login_user_role = Helper::getLoginUserRole();
                $data = User::with(['roles']);
                if($login_user_role == "admin"){
                    $data = $data->whereHas("roles", function($q){
                        $q->whereNotIn("name", ["developer","admin"]);
                    });
                }else if($login_user_role != "developer"){
                    $data = $data->whereHas("roles", function($q){
                        $q->whereNotIn("name", ["developer"]);
                    });
                }
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
            View::share('modules', $modules);
            
            // $roles = Role::pluck('name','name')->all();
            $login_user_role = Auth::user()->getRoleNames()->first();
            $roles = new Role();
            if($login_user_role == "admin"){
                $roles = $roles->whereNotIn("name", ["developer","admin"]);
            }else if($login_user_role != "developer"){
                // $roles = $roles->whereNotIn("name", ["developer","admin"]);
            }
            $roles = $roles->get();
            return view('admin.templates.'.$modules['folder_path'].'.form',compact('roles'));
            
        } catch (\Exception $e) {
            return $e->getMessage();
            //throw $th;
        }
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(UserRequest $request)
    {
        try {            
            $modules = $this->modules;
            
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            
            // dd($request->all(),$input);
            $user = User::create($input);
            $user->assignRole($request->input('role'));
            
            return Redirect::route($modules['route'].'.index')->with('success', $modules['title'].' create successfully.');
        } catch (\Exception $e) {
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
        try{
            $modules = $this->modules;
            $modules['title'] = 'Edit '.$modules['title'];
            $edit = User::with('roles')->findOrFail($id);
            
            // $roles = Role::select('id','name','guard_name')->get();
            $login_user_role = Auth::user()->getRoleNames()->first();
            $roles = new Role();
            if($login_user_role == "admin"){
                $roles = $roles->whereNotIn("name", ["developer","admin"]);
            }else if($login_user_role != "developer"){
                // $roles = $roles->whereNotIn("name", ["developer","admin"]);
            }
            $roles = $roles->get();
            $selectedRole = "";
            if(count($edit->roles) > 0){
                $selectedRole =$edit->roles->pluck('id')->first();
            }
            // return $edit->roles->pluck('id')->first();
            return view('admin.templates.' . $modules['folder_path'] . '.form', compact('modules','edit','roles','selectedRole'));
        }
        catch(\Exception $e) {
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage());
        }
    }
    
    public function update(UserRequest $request, string $id)
    {
        DB::beginTransaction();
        try{
            $modules = $this->modules;
            return $updateData = $request->all();
            
            unset($updateData['password']);
            
            $user = User::findOrFail($id);
            if($user){
                $user->name = $request?->name;
                $user->email = $request?->email;
                if($request->password && !empty($request->password)){
                    $updateData['password'] = Hash::make($request->password);
                }
                $user->status = $request?->status;
                $user->save();
                
                $user->syncRoles($request->input('role'));
                
                // DB::table('model_has_roles')->where('model_id',$id)->delete();
                // $user->assignRole($request->input('role'));
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
            $dataDelete = User::findOrFail($id);
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

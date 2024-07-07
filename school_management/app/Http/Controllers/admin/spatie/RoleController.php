<?php

namespace App\Http\Controllers\admin\spatie;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public $modules = [];
    public function __construct()
    {
        $this->modules = [
            'title' => 'Role',
            'folder_path' => 'spatie.role',
            'table_name' => (new Role())->getTable(),
            'route' => 'roles',
            'permisstion_prefix' => 'roles',
        ];
        
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-list', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->modules['permisstion_prefix'].'-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        try{
            $modules = $this->modules;
            
            if($request->ajax()){
                // dd($request->all());
                $data = Role::withCount('users');
                
                $login_user_role = Helper::getLoginUserRole();
                if($login_user_role != "developer"){
                    $data = $data->whereNotIn("name", ["developer"]);
                }
                $editPermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-edit')) ? true : false;
                $deletePermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-delete')) ? true : false;
                
                $returnData = Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('name', 'like',"%".$request->search."%");
                    }
                })
                ->addColumn('action', function($row) use ($modules, $editPermisstion, $deletePermisstion){
                    $btn = '';
                    // $btn .= '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    if($editPermisstion){
                        $btn .= '<a href="'.route($modules["route"].".edit",[$row["id"]]).'" class="btn btn-primary btn-icon"><i class="fa-solid fa-pen-to-square"></i></a>';
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
                ->rawColumns(['user_count','action'])
                ->make(true);
                // dd($returnData);
                return $returnData;
            }
            
            return view('admin.templates.'.$modules['folder_path'].'.index', compact('modules'));
        } catch (\Exception $e) {
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage())->withInput();
        }
    }
    
    public function create()
    {
        $modules = $this->modules;
        $permission = Permission::get();
        
        return view('admin.templates.'.$modules['folder_path'].'.form', compact('modules','permission'));
    }
    
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try{
            $modules = $this->modules;
            // return $request->all();
            $validated = $request->all();
            $role = Role::create($validated);
            
            $getPermissions = Permission::whereIn('id', $request->permission)->get();
            if(count($getPermissions) > 0){
                $getPermissions = $getPermissions->pluck('name');
            }
            // return $getPermissions;
            $role->syncPermissions($getPermissions);
            // $role->syncPermissions($request->input('permission'));
            DB::commit();
            return Redirect::route($modules['route'].'.index')->withSuccess($modules['title'].' create successfully');
        }
        catch(\Exception $e) {
            DB::rollBack();
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage());
        }
    }
    
    public function show(string $id)
    {
        $modules = $this->modules;
        return Redirect::route($modules['route'].'.index');
    }
    
    public function edit(string $id)
    {
        $modules = $this->modules;
        
        $edit = Role::findOrFail($id);
        $permission = Permission::get();
        // return 
        
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        
        return view('admin.templates.'.$modules['folder_path'].'.form', compact('modules','edit','permission','rolePermissions'));
    }
    
    public function update(RoleRequest $request, string $id)
    {
        DB::beginTransaction();
        try{
            $modules = $this->modules;            
            
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();
            
            $getPermissions = Permission::whereIn('id', $request->permission)->get();
            if(count($getPermissions) > 0){
                $getPermissions = $getPermissions->pluck('name');
            }
            // return $getPermissions;
            $role->syncPermissions($getPermissions);
            // $role->syncPermissions($request->input('permission'));
            
            DB::commit();
            return Redirect::route($modules['route'].'.index')->withSuccess($modules['title'].' update successfully');
            
            return Redirect::back()->withErrors('something went wrong please try again later')->withInput();
        }
        catch(\Exception $e) {
            DB::rollBack();
            return Redirect::route($modules['route'].'.index')->withErrors($e->getMessage());
        }
        
    }
    
    public function destroy(string $id)
    {
        $modules = $this->modules;
        $dataDelete = Role::findOrFail($id);
        if($dataDelete){
            if($dataDelete->delete()){
                // return Redirect::route($modules['route'].'.index');
                return true;
            }
        }
        return false;
    }
}

<?php

namespace App\Http\Controllers\admin\spatie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public $modules = [];
	public function __construct()
	{
		$this->modules = [
			'title' => 'Permission',
			'folder_path' => 'spatie.permission',
			'route' => 'permissions',
			'table_name' => 'permissions',
			'permisstion_prefix' => 'permissions',
		];

		// $this->middleware('permission:permissions-list|permissions-create|permissions-edit|permissions-delete', ['only' => ['index','show']]);
		$this->middleware('permission:'.$this->modules['permisstion_prefix'].'-list', ['only' => ['index','show']]);
		$this->middleware('permission:'.$this->modules['permisstion_prefix'].'-create', ['only' => ['create','store']]);
		$this->middleware('permission:'.$this->modules['permisstion_prefix'].'-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:'.$this->modules['permisstion_prefix'].'-delete', ['only' => ['destroy']]);
	}

	public function index(Request $request)
	{
		$modules = $this->modules;
        View::share('modules', $modules);

		if($request->ajax()){
			$editPermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-edit')) ? true : false;
			$deletePermisstion = (Auth::user()->can($modules["permisstion_prefix"].'-delete')) ? true : false;

			// dd($request->all());
        
			$data = Permission::select('id','name');
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
			})
			->rawColumns(['action'])
			->make(true);
			return $returnData;
		}

		return view('admin.templates.'.$modules['folder_path'].'.index', compact('modules'));

	}

	public function create()
	{
		$modules = $this->modules;
        $modules['title'] = "Create ".$modules['title'];

		return view('admin.templates.'.$modules['folder_path'].'.form', compact('modules'));
	}

	public function store(Request $request)
	{
		$modules = $this->modules;
		// return $request->all();
		$validated = $request->validate([
			'name' => 'required|unique:'.$modules['table_name'].'|max:255',
		]);

		Permission::create($validated);

		$role = Role::where('name','Developer')->first();
		if($role){
			$permissions = Permission::pluck('id','id')->all();

			$role->syncPermissions($permissions);
		}
		return redirect()->route($modules['route'].'.index')->withSuccess($modules['title'].' create successfully');
		return $validated;
	}

	public function show(string $id)
	{
		$modules = $this->modules;
		return redirect()->route($modules['route'].'.index');
	}

	public function edit(string $id)
	{
		$modules = $this->modules;
        $modules['title'] = "Edit ".$modules['title'];
		$edit = Permission::findOrFail($id);
		return view('admin.templates.'.$modules['folder_path'].'.form', compact('modules','edit'));
	}


	public function update(Request $request, string $id)
	{
		$modules = $this->modules;
		$request['id'] = $id;
		// return $request->all();
		$validated = $request->validate([
			'id' => 'required|exists:'.$modules['table_name'].',id',
			'name' => 'required|unique:'.$modules['table_name'].',name,'.$id.'|max:255',
		]);
		$update = Permission::findOrFail($id);
		if($update){
			unset($validated['id']);
			$update->update($validated);
			return redirect()->route($modules['route'].'.index')->withSuccess($modules['title'].' update successfully');
		}
		return redirect()->back()->withErrors('something went wrong please try again later')->withInput();
		return $validated;
	}


	public function destroy(string $id)
	{
		$modules = $this->modules;
		$dataDelete = Permission::findOrFail($id);
		if($dataDelete){
			if($dataDelete->delete()){
				// return redirect()->route($modules['route'].'.index');
				// return redirect()->route($modules['route'].'.index')->withErros('Something want to wrong');
				return true;
			}
		}
		return false;
	}
}

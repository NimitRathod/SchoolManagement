<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Dashboard extends Controller
{
    public $modules = [];
    
    public function __construct()
    {
        
        $this->modules = [
            'title' => 'Dashbaord',
            'folder_path' => '',
            'route' => '',
            'table_name' => '',
            'permisstion_prefix' => '',
        ];
        
    }

    public function index(Request $request){
        $modules = $this->modules;
        View::share('modules', $modules);
        
        return view('admin.templates'.$modules['folder_path'].'.dashboard');
    }
}

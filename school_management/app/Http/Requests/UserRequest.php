<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request)
    {
        $id = !empty($request->route('user')) ? $request->route('user') : 0;
        if(!$id){
            $id = !empty($request->route('user-management')) ? $request->route('user-management') : 0;
            if(!$id && !empty($request?->id)){
                $id = $request?->id;
            }
        }
        $password_rule = 'required|min:3';
        if($id){
            $password_rule = 'nullable|min:3';
        }
        
        $rule = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:'.(new User())->getTable().',email,' . $id . ',id,deleted_at,NULL,status,active',
            'password' => $password_rule,
            'role' => 'required|exists:'.(new Role())->getTable().',name|max:255',
            'status' => 'required|in:active,inactive',
        ];
        return $rule;
    }
}

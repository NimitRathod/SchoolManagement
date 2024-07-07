<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleRequest extends FormRequest
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
        $id = !empty($request->route('roles')) ? $request->route('roles') : 0;
        if(!$id && !empty($request?->id)){
            $id = $request?->id;
        }
        
        $rule = [
            'name' => 'required|max:255|unique:'.(new Role())->getTable().',name,'.$id,
            'permission' => 'nullable',
        ];
        return $rule;
    }
}

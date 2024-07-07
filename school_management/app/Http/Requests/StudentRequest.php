<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StudentRequest extends FormRequest
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
        $id = !empty($request->route('students')) ? $request->route('students') : 0;
        if(!$id && !empty($request?->id)){
            $id = $request?->id;
        }
        $password_rule = 'required|min:3';
        if($id){
            $password_rule = 'nullable|min:3';
        }
        $rule = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:'.(new Student())->getTable().',email,' . $id . ',id,deleted_at,NULL,status,active',
            'password' => $password_rule,
            'status' => 'required|in:active,inactive',
        ];
        // dd($id, $request->all(), $password_rule, $rule);
        return $rule;
    }
}

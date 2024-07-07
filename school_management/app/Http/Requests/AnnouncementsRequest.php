<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AnnouncementsRequest extends FormRequest
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
        $id = !empty($request->route('announcements')) ? $request->route('announcements') : 0;
        if(!$id && !empty($request?->id)){
            $id = $request?->id;
        }
        $rule = [
            'announced_by' => 'array',
            'announced_by.*' => 'required|in:teachers,students,parents',
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ];
        // dd($id, $request->all(), $password_rule, $rule);
        return $rule;
    }
}

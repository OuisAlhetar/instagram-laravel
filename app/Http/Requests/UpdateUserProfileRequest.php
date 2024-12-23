<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('edit-update-profile', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', Rule::unique('users')->ignore($this->user())],
            'bio' => 'nullable',
            'image' => 'image',
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['min:8', 'nullable', 'confirmed'],
            'lang' => 'required'
        ];
    }
}

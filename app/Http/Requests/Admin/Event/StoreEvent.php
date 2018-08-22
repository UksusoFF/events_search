<?php

namespace App\Http\Requests\Admin\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return Gate::allows('admin.event.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'vid' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'photo_200' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'ignored' => ['required', 'boolean'],
        ];
    }
}

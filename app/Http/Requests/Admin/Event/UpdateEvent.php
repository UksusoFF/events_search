<?php

namespace App\Http\Requests\Admin\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return Gate::allows('admin.event.edit', $this->event);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'vid' => ['sometimes', 'string'],
            'name' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'photo_200' => ['sometimes', 'string'],
            'start_date' => ['nullable', 'date'],
            'ignored' => ['sometimes', 'boolean'],
        ];
    }
}

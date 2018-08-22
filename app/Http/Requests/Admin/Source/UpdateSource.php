<?php

namespace App\Http\Requests\Admin\Source;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSource extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return Gate::allows('admin.source.edit', $this->source);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'type' => ['sometimes', 'string'],
            'user_id' => ['sometimes', 'integer'],
            'source' => ['sometimes', 'string'],
            'map_id' => ['sometimes', 'string'],
            'map_title' => ['sometimes', 'string'],
            'map_desc' => ['sometimes', 'string'],
            'map_image' => ['sometimes', 'string'],
            'map_date' => ['sometimes', 'string'],
        ];
    }
}

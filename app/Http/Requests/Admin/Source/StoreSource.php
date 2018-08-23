<?php

namespace App\Http\Requests\Admin\Source;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreSource extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return Gate::allows('admin.source.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string'],
            'source' => ['required', 'string'],
            'title' => ['required', 'string'],
            'map_items' => ['required', 'string'],
            'map_id' => ['required', 'string'],
            'map_title' => ['required', 'string'],
            'map_desc' => ['required', 'string'],
            'map_image' => ['required', 'string'],
            'map_date' => ['required', 'string'],
            'map_date_format' => ['required', 'string'],
        ];
    }
}

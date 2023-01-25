<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Carbon;

class NewBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:200',
            'description' => 'required'
        ];
    }

    public function store() {
        return $this->user()->blogs()->create(array_merge(
            $this->safe()->only(['title', 'description']),
            ['published_at' => Carbon::now()]
        ));
    }
}

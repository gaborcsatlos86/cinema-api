<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObjects\MovieStoreDTO;

class MovieStoreRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:1', 'max:255'],
            'description' => [],
            'ageLimit' => ['required'],
            'lang' => ['required'],
            'coverImage' => []
        ];
    }
    
    public function toDTO(): MovieStoreDTO
    {
        return new MovieStoreDTO(
            title: $this->title,
            description: $this->description,
            ageLimit: $this->ageLimit,
            lang: $this->lang,
            coverImage: $this->coverImage
        );
    }
}

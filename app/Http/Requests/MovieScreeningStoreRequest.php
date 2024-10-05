<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObjects\MovieScreeningStoreDTO;

class MovieScreeningStoreRequest extends FormRequest
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
            'movie_id' => ['required'],
            'room_id' => ['required'],
            'start' => ['required'],
            'free_positions' => ['required'],
        ];
    }
    
    public function toDTO(): MovieScreeningStoreDTO
    {
        return new MovieScreeningStoreDTO(
            movie_id: $this->movie_id,
            room_id: $this->room_id,
            start: new \DateTimeImmutable($this->start),
            free_positions: $this->free_positions
        );
    
    }
}

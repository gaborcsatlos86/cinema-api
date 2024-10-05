<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class MovieStoreDTO extends DataTransferObject
{
    public string $title;
    public ?string $description = null;
    public int $ageLimit;
    public string $lang;
    public ?UploadedFile $coverImage = null;
    
    public static function getKeys(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'ageLimit' => 'int',
            'lang' => 'string',
            'coverImage' => 'file'
        ];
    }
    
}

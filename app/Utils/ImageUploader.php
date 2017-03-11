<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    public static function store(UploadedFile $file, $path, $name)
    {
        $file->move(public_path() . $path, $name);
    }
}
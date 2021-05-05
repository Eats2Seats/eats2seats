<?php


namespace App\Helpers\FileNames;


use Illuminate\Http\UploadedFile;

class RandomFileNameGenerator implements FileNameGenerator
{

    public function generate(UploadedFile $file): string
    {
        $pool = 'ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklnmopqrstuvwxyz0123456789';
        $name = substr(str_shuffle(str_repeat($pool, 32)), 0, 32);
        $extension = $file->getClientOriginalExtension();
        return "{$name}.{$extension}";
    }
}

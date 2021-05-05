<?php


namespace App\Helpers\FileNames;


use Illuminate\Http\UploadedFile;

interface FileNameGenerator
{
    public function generate(UploadedFile $file): String;
}

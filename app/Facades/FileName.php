<?php


namespace App\Facades;


use App\Helpers\FileNames\FileNameGenerator;
use Illuminate\Http\UploadedFile;

/**
 * @method static generate(UploadedFile $file)
 */
class FileName extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FileNameGenerator::class;
    }

    protected static function getMockableClass(): string
    {
        return static::getFacadeAccessor();
    }
}

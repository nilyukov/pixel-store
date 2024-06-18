<?php

namespace App\Http\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Where;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Where('method', 'resize|crop|fit')]
#[Where('size', '\d+x\d+')]
#[Where('file', '.+\.(png|jpg|jpeg|git|webp)$')]
class ThumbnailController extends Controller
{
    #[Get('/storage/images/{dir}/{method}/{size}/{file}', name: 'thumbnail')]
    public function __invoke(
        string $dir,
        string $method,
        string $size,
        string $file
    ): BinaryFileResponse
    {
        abort_if(
            !in_array($size, config('thumbnail.allowed_sizes', [])),
            403,
            'Size not allowed'
        );

        $storage = Storage::disk('images');

        $realPath = "$dir/$file";
        $newDirPath = "$dir/$method/$size";
        $resultPath = "$newDirPath/$file";

        if(!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        if(!$storage->exists($resultPath)) {
            $image = Image::read($storage->path($realPath));

            [$w, $h] = explode('x', $size);
            $image->{$method}($w, $h);

            $image->save($storage->path($resultPath), 100);
        }

        return response()->file($storage->path($resultPath));
    }
}

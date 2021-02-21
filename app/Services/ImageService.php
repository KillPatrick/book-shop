<?php


namespace App\Services;

use Intervention\Image\Facades\Image;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Str;

class ImageService
{
    public static function storeImage(StoreBookRequest $request)
    {
        $img = Image::make($request->image->path());
        $name = Str::random(28).'.'.$request->image->extension();
        $destinationPath = public_path('/Storage/Images');
        $img->resize(480, 640, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$name);

        return $img->basename;
    }
}

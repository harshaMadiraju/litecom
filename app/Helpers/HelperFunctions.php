<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HelperFunctions
{
    public function UploadImage($request)
    {
        $folder_name = 'files';

        if ($request->hasFile('file')) {
            //normal fille
            $file = $request->file('file');
            $filename = Str::random(10) . "." . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($folder_name . '/' . $filename, $file);

            return $folder_name . '/' . $filename;
        } else {
            //base64 
            $name = Str::random(10) . '.png';
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('file')));
            Storage::disk('s3')->put($folder_name . '/' . $name, $file);

            return $folder_name . '/' . $name;
        }
    }

    public static function getImage($image_name)
    {
        if ($image_name) {
            return Storage::disk('s3')->url($image_name);
        }

        return null;
    }
}

<?php

namespace App\Http\traits;

trait UploadFile
{

    private function uploadFile($path, $file, $old_file = null)
    {
        if ($old_file != null) {
            $this->removeFile($path, $old_file);
        }
        $image_name = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path($path), $image_name);
        return $image_name;
    }


    private function removeFile($path, $file_name)
    {
        $file_path = public_path($path .'/'. $file_name);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

}

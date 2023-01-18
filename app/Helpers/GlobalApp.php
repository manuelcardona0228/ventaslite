<?php
namespace App\Helpers;

class GlobalApp
{
    public static function saveFile($file, $folder_name)
    {
        $customFileName = uniqid() . '_.' . $file->extension();
        $file->storeAs('public/' . $folder_name, $customFileName);

        return $customFileName;
    }

    public static function viewImage($image, $folder): string
    {
        $path_url = 'storage/' . $folder . '/';

        return $image === null || !file_exists($path_url . $image)
            ? 'assets/img/200x200.jpg'
            : $path_url . $image;
    }
}

<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Compress and save image using GD library
     * 
     * @param $sourcePath
     * @param $destinationPath
     * @param $quality (0-100)
     * @return bool
     */
    public static function compressImage($source, $destination, $quality = 75)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            // Handle transparency for PNG
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        } else {
            return false;
        }

        // Save the image
        imagejpeg($image, $destination, $quality);
        imagedestroy($image);

        return true;
    }
}

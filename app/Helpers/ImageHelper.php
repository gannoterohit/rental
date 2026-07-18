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
        if (!$info || empty($info['mime'])) {
            return false;
        }

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
        } elseif ($info['mime'] == 'image/webp' && function_exists('imagecreatefromwebp')) {
            $image = imagecreatefromwebp($source);
        } else {
            return false;
        }

        if (!$image) {
            return false;
        }

        // Save the image
        $saved = imagejpeg($image, $destination, $quality);
        imagedestroy($image);

        return $saved;
    }
}

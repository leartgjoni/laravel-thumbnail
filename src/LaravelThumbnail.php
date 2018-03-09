<?php
namespace Lersoft\LaravelThumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
class LaravelThumbnail
{
    //type:
    // fit - best fit possible for given width & height - by default
    //resize - exact resize of image
    //background - fit image perfectly keeping ratio and adding black background
    //resizeCanvas - keep only center
    public static function thumb($path, $width = null, $height = null, $type = "fit")
    {
        $images_path = config('thumb.images_path');
        $path = ltrim($path, "/");

        //if path exists and is image
        if(File::exists(public_path("{$images_path}/" . $path))){

            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = mime_content_type(public_path("{$images_path}/" . $path));

            if(in_array($contentType, $allowedMimeTypes)){
                //returns the original image if no width and height
                if (is_null($width) && is_null($height)) {
                    return url("{$images_path}/" . $path);
                }

                //if thumbnail exist returns it
                if (File::exists(public_path("{$images_path}/thumbs/" . "{$width}x{$height}_{$type}/" . $path))) {
                    return url("{$images_path}/thumbs/" . "{$width}x{$height}_{$type}/" . $path);
                }


                $image = Image::make(public_path("{$images_path}/" . $path));

                switch ($type) {
                    case "fit": {
                        $image->fit($width, $height, function ($constraint) {
                        });
                        break;
                    }
                    case "resize": {
                        //stretched
                        $image->resize($width, $height);
                    }
                    case "background": {
                        $image->resize($width, $height, function ($constraint) {
                            //keeps aspect ratio and sets black background
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    }
                    case "resizeCanvas": {
                        $image->resizeCanvas($width, $height, 'center', false, 'rgba(0, 0, 0, 0)'); //gets the center part
                    }
                }

                //relative directory path starting from main directory of images
                $dir_path = (dirname($path) == '.') ? "" : dirname($path);

                //Create the directory if it doesn't exist
                if (!File::exists(public_path("{$images_path}/thumbs/" . "{$width}x{$height}_{$type}/" . $dir_path))) {
                    File::makeDirectory(public_path("{$images_path}/thumbs/" . "{$width}x{$height}_{$type}/" . $dir_path), 0775, true);
                }

                //Save the thumbnail
                $image->save(public_path("{$images_path}/thumbs/" . "{$width}x{$height}_{$type}/" . $path));

                //return the url of the thumbnail
                return url("{$images_path}/thumbs/" . "{$width}x{$height}_{$type}/" . $path);

            } else {
                $width = is_null($width) ? 400 : $width;
                $height = is_null($height) ? 400 : $height;

                // returns an image placeholder generated from placehold.it
                return "http://placehold.it/{$width}x{$height}";
            }

        } else {
            $width = is_null($width) ? 400 : $width;
            $height = is_null($height) ? 400 : $height;

            // returns an image placeholder generated from placehold.it
            return "http://placehold.it/{$width}x{$height}";
        }
    }
}
# Laravel Thumbnail

Laravel Package to resize images on the fly with cache functionalities. <br/><br/>
Using Thumbnail facade you will get resized images' paths on the fly. If an image resizing with same dimensions has been already requested before, the package will return the cached image from the previous request. Cached images are stored in "thumbs" folder inside your images root path. 

## Installation

    1. composer require lersoft/laravel-thumbnail dev-master
    2. in config/app.php add in providers: Lersoft\LaravelThumbnail\LaravelThumbnailServiceProvider::class
    3. in config/app.php add in aliases: 'Thumbnail' => Lersoft\LaravelThumbnail\Facades\LaravelThumbnail::class
    4. php artisan vendor:publish --tag=config
    
## How to use

In your blade view insert:
    
    <img src="{{Thumbnail::thumb("test.png", 800, 300)}}" />
    
thumb function takes 4 parameters:

    1. path of image (change root path in config/thumb.php
    2. $width (nullable)
    3. $height (nullable)
    4. $type (by default = fit). Types are:
        a. "fit" - best fit possible for given width & height
        b. "resize" - exact resize of image
        c. "background" - fit image perfectly keeping ratio and adding black background
        d. "resizeCanvas" - keep only center

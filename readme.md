# Laravel Thumbnail

Laravel Package to resize images on the fly with cache functionalities

## Installation

    1. composer required lersoft/laravel-thumbnail
    2. in config/app.php add in providers: Lersoft\LaravelThumbnail\LaravelThumbnailServiceProvider::class
    3. in config/app.php add in aliases: 'Thumbnail' => Lersoft\LaravelThumbnail\Facades\LaravelThumbnail::class
    4. php artisan vendor:public --tag=config
    
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
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/bootstrap.bundle.min.js', 'public/js/bootstrap.bundle.min.js')
    .js('resources/js/main.js', 'public/js/main.js')
    .postCss('resources/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
    .postCss('resources/css/main.css', 'public/css/main.css')
    .postCss('resources/css/lineicons.css', 'public/css/lineicons.css')
    .copy('resources/images', 'public/images');

const mix = require('laravel-mix');


var paths = {
    'lazyload': './node_modules/jquery-lazyload/',
}


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');


mix.styles([
    'resources/assets/css/fonts.css',
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/selectize.css',
    'resources/assets/css/slick.css',
    'resources/assets/css/datepicker.css',
    'resources/assets/css/fontello.css'
], 'public/css/mymdb.css')


mix.scripts([
    'resources/assets/js/jquery.js',
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/waves.js',
    'resources/assets/js/selectize.js',
    'resources/assets/js/autosize.js',
    'resources/assets/js/parallax.js',
    'resources/assets/js/datepicker.js',
    paths.lazyload + "jquery.lazyload.js",
    'resources/assets/js/sly.js',
    'resources/assets/js/setup.js',

],'public/js/mymdb.js')
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

mix.styles([
    'resources/views/css/reset.css',
    'resources/views/css/app.css',
    'resources/views/css/main.css'
], 'public/css/main.css')

.scripts([
    'resources/views/js/binance.js'
], 'public/js/main.js')

.version();


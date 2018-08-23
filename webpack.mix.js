let mix = require('laravel-mix');

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

mix.js('resources/assets/scripts/app.js', 'public/scripts')
    .version();
mix.sass('resources/assets/styles/app.scss', 'public/styles')
    .version();
mix.copy('node_modules/font-awesome/fonts/*.*', 'public/fonts');

if (mix.inProduction()) {
    mix.version();
}
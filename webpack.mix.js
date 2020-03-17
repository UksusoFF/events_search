const mix = require('laravel-mix');

mix.js('resources/assets/scripts/app.js', 'public/scripts').version();

mix.sass('resources/assets/styles/app.scss', 'public/styles').version();

mix.copy('node_modules/font-awesome/fonts/*.*', 'public/fonts');

if (mix.inProduction()) {
    mix.version();
}
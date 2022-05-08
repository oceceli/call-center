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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .copy('node_modules/primevue/resources/themes/md-light-indigo/theme.css', 'public/css/prime-theme.css')
    .copy('node_modules/primevue/resources/themes/md-light-indigo/fonts', 'public/css/fonts')
    .copy('node_modules/primevue/resources/primevue.min.css', 'public/css')
    .copy('node_modules/primeicons/primeicons.css', 'public/css')
    .copy('node_modules/primeicons/fonts', 'public/css/fonts')
    .alias({
        '@': 'resources/js',
    });
    // md-light-indigo fluent-light luna-amber

if (mix.inProduction()) {
    mix.version();
}

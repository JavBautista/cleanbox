const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    // CoreUI
    .styles([
            'resources/templates/coreui/css/font-awesome.min.css',
            'resources/templates/coreui/css/simple-line-icons.min.css',
            'resources/templates/coreui/css/style.css'
            ],'public/css/dashboard.css')
    .scripts([
            'resources/templates/coreui/js/pace.min.js',
            'resources/templates/coreui/js/Chart.min.js',
            'resources/templates/coreui/js/template.js',
            'resources/templates/coreui/js/sweetalert2.all.min.js'
            ],'public/js/dashboard.js')
    //eShopper
    .styles([
        'resources/templates/eshopper/lib/owlcarousel/assets/owl.carousel.min.css',
        'resources/templates/eshopper/css/style.css'
    ], 'public/css/eshopper.css')
    .scripts([
        'resources/templates/eshopper/lib/easing/easing.min.js',
        'resources/templates/eshopper/lib/owlcarousel/owl.carousel.min.js',
        'resources/templates/eshopper/js/main.js'
    ], 'public/js/eshopper.js')
    .vue()
    .sourceMaps();

mix.browserSync('http://cleanbox.local/');
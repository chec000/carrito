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

mix.scripts([
	'resources/assets/js/jquery-3.1.1.min.js',
	'resources/assets/js/jquery-ui.js',
	'resources/assets/js/tether.min.js',
	'resources/assets/js/bootstrap.min.js',
	'resources/assets/js/slick.min.js',
	'resources/assets/js/vue.min.js',
	'resources/assets/js/axios.js',
  'resources/assets/js/localization.js',
	'resources/assets/js/general_scripts.js',
  'resources/assets/js/product_js.js',
  'resources/assets/js/jquery_scripts.js',
	], 'public/js/app.js');

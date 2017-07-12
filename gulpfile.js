var elixir = require('laravel-elixir');
var gulp = require('gulp');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.scripts([
			'admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
			'admin-lte/bootstrap/js/bootstrap.min.js',
			'admin-lte/dist/js/app.min.js',
			'bootstrap-chosen/dist/chosen.jquery-1.4.2/chosen.jquery.min.js',
			'admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
			'admin-lte/plugins/bootstrap-slider/bootstrap-slider.js',
			'admin-lte/plugins/datatables/jquery.dataTables.min.js',
			'admin-lte/plugins/datatables/dataTables.bootstrap.min.js',
		],
		'public/assets/js/app.js',
		'node_modules/'
	).less([
			'admin-lte/build/less/AdminLTE.less'
		],
		'public/assets/css/adminlte.css',
		'node_modules/'
	).less([
			'admin-lte/build/less/skins/skin-black.less'
		],
		'public/assets/css/skin-black.css',
		'node_modules/'
	).less([
			'font-awesome/less/font-awesome.less'
		],
		'public/assets/css/font-awesome.css',
		'node_modules/'
	).less([
			'../resources/assets/less/style.less'
		],
		'public/assets/css/style.css',
		'node_modules/'
	).styles([
			'admin-lte/bootstrap/css/bootstrap.min.css',
			'admin-lte/plugins/datatables/dataTables.bootstrap.css',
			'admin-lte/plugins/bootstrap-slider/slider.css',
			'bootstrap-chosen/bootstrap-chosen.css',
			'../public/assets/css/style.css',
			'../public/assets/css/font-awesome.css',
		],
		'public/assets/css/app.css',
		'node_modules/'
	).copy(
			'node_modules/admin-lte/bootstrap/fonts', 
			'public/assets/fonts'	
	).copy(
			'node_modules/font-awesome/fonts', 
			'public/assets/fonts'
	).copy(
			'node_modules/bootstrap-chosen/chosen-sprite.png', 
			'public/assets/css'
	).copy(
			'node_modules/bootstrap-chosen/chosen-sprite@2x.png', 
			'public/assets/css'
	).copy(
			'resources/assets/json', 
			'public/assets/json'	
	);
});
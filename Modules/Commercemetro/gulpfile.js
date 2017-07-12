var elixir = require('laravel-elixir');
var gulp = require('gulp');

elixir(function(mix) { 	
	mix.copy(
		'../../node_modules/admin-lte/plugins/morris/morris.min.js', 
		'../../public/assets/js/morris.js'
	).copy( 
		'../../node_modules/admin-lte/plugins/morris/morris.css',
		'../../public/assets/css/morris.css'
	).copy( 
		'../../node_modules/raphael/raphael.min.js',
		'../../public/assets/js/raphael.js'
	);
});


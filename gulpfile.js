var elixir = require('laravel-elixir');
elixir(function (mix) {
    mix.sass('app.scss').scripts([
        '../../../bower_components/angular/angular.min.js',
        'angular/controllers/search.js',
    ], 'public/js/app.js')
            .copy('bower_components/mdi/fonts', 'public/fonts')
            .copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts');
});

// Load Gulp
const { src, dest, task, watch, series, parallel } = require( 'gulp' );

// CSS related plugins
var autoprefixer    = require( 'gulp-autoprefixer' );
var sass            = require( 'gulp-sass' );

// JS related plugins
var babelify        = require( 'babelify' );
var browserify      = require( 'browserify' );
var buffer          = require( 'vinyl-buffer' );
var source          = require( 'vinyl-source-stream' );
var uglify          = require( 'gulp-uglify' );

// Utility Plugins
var rename          = require( 'gulp-rename' );
var sourcemaps      = require( 'gulp-sourcemaps' );
var notify          = require( 'gulp-notify' );

// Browser related plugins
var browserSync     = require( 'browser-sync' );

// Project related variables
var styleSRC        = './sass/';
var styleURL        = './css/';
var styleFiles      = ['sunset.scss', 'sunset.admin.scss', 'sunset.ace.scss'];
var mapURL          = './';

var jsSRC           = './js/';
var jsFront         = 'script.js';
var jsFiles         = [ jsFront ];
var jsURL           = './js/';

var imageWatch      = './img/**/*.img';
var styleWatch      = './sass/**/*.scss';
var jsWatch         = './js/**/*.js';

var phpWatch        = ['./*.php', './**/*.php', './inc/**/*.php'];

// Task functions
function browser_sync() {
    browserSync.init({
        open: false,
        injectChanges: false,
        proxy: 'http://sunset.test/'
    });
}

function reload( done ) {
    browserSync.reload();
    done();
}

function css( done ) {
    styleFiles.map( function( file ) {
        return  src( styleSRC + file )
            .pipe( sourcemaps.init() )
            .pipe( sass({
                errorLogConsole: true,
                outputStyle: 'compressed'
            }) )
            .on( 'error', console.error.bind( console ) )
            .pipe( autoprefixer({
                cascade: false
            }) )
            .pipe( rename({
                suffix: '.min'
            }) )
            .pipe( sourcemaps.write( mapURL ) )
            .pipe( dest( styleURL ) )
            .pipe( browserSync.stream() );
    } );
    done();
}

function js(done) {
    jsFiles.map( function( entry ) {
        return browserify({
            entries: [jsSRC + entry]
        })
            .transform( babelify, { presets: [ '@babel/preset-env' ] } )
            .bundle()
            .pipe( source( entry ) )
            .pipe( rename( {
                extname: '.min.js'
            } ) )
            .pipe( buffer() )
            .pipe( sourcemaps.init({ loadMaps: true }) )
            .pipe( uglify() )
            .pipe( sourcemaps.write( '.' ) )
            .pipe( dest( jsURL ) )
            .pipe( browserSync.stream() );
    });
    done();
}

function watch_files() {
    watch( styleWatch, series( css, reload ) );
    watch( jsWatch, reload );
    watch( imageWatch, reload );

    phpWatch.forEach( function( url ) {
        watch( url, reload);
    } );

    src( './notify.txt' )
        .pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
}

// Tasks
task( 'js', js );
task( 'css', css );
task( 'browser_sync', browser_sync );
task( 'default', parallel( css, js ) );
task( 'watch', parallel( browser_sync, watch_files ) );


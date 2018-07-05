var autoprefixer = require('autoprefixer');
var browserify  = require('browserify');
var babelify    = require('babelify');
var source      = require('vinyl-source-stream');
var buffer      = require('vinyl-buffer');
var uglify      = require('gulp-uglify');
var livereload  = require('gulp-livereload');
var fs = require('fs');
var path = require('path');


var browserify = require('browserify');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var del = require('del');
var fs = require('fs');
var gulp = require('gulp');
var util = require('gulp-util');
var imagemin = require('gulp-imagemin');
var notify = require('gulp-notify');
var minify = require('gulp-minify');
var plumber = require('gulp-plumber');
var postcss = require('gulp-postcss');
var pngquant = require('imagemin-pngquant');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var transform = require('vinyl-transform');
var watch = require('gulp-watch');
var wpPot = require('gulp-wp-pot');


function swallowError(error){
  this.emit('end');
}

var config = {
  production: true
};

// dir paths
var paths = {
  srcPath: './src',
  assetsPath: '../assets',
  adminSrcPath: './admin-src',
  adminAssetsPath: '../inc/admin/assets',
  npmPath : './node_modules',
  bowerPath: './bower_components',
  vendorPath: './js/vendor',
  gutenbergSrc: './gutenberg',
  gutenbergBuilds: '../inc/gutenberg/blocks'
};
paths.scssGlob = paths.srcPath + '/scss/**/*.scss';
paths.jsGlob = paths.srcPath + '/js/**/*.js';
paths.adminScssGlob = paths.adminSrcPath + '/scss/**/*.scss';
paths.adminJSGlob = paths.adminSrcPath + '/js/**/*.js';



// ---------------------------------------------------------------------------
//  The frontend assets
// ---------------------------------------------------------------------------

//
// GutenBerg
//

// the folder structure
function getFolders(dir) {
  return fs.readdirSync(dir)
  .filter(function(file) {
    return fs.statSync(path.join(dir, file)).isDirectory();
  });
}

gulp.task('gutenberg_js', function() {
   var folders = getFolders(paths.gutenbergSrc);

   var tasks = folders.map(function(folder) {
   		var file = 'block.js';
   		var srcPath = paths.gutenbergSrc + '/' + folder + '/js/' + file;
   		var blockPath = paths.gutenbergBuilds + '/' + folder;
   		console.log(srcPath, blockPath, file);
			
			return browserify({entries: srcPath, debug: true})
			.transform("babelify", { presets: ["es2015"], plugins: ['transform-react-jsx'] })
			.bundle()
			.pipe(source(file))
			.pipe(buffer())
			.pipe(sourcemaps.init())
			.pipe(uglify())
			.pipe(sourcemaps.write('./maps'))
			.pipe(gulp.dest(blockPath));
   });

   return tasks; //merge(tasks, root);
});

// gutenberg scss
gulp.task('gutenberg_css', function() {
   var folders = getFolders(paths.gutenbergSrc);
   var tasks = folders.map(function(folder) {

   		let srcPath = paths.gutenbergSrc + '/' + folder + '/css/';
   		let blockPath = paths.gutenbergBuilds + '/' + folder + '/';

		  return gulp.src([
		      srcPath + 'backend.scss',
		      srcPath + 'frontend.scss'
		    ])
		    .pipe(plumber({ errorHandler: handleErrors }))
		    // .pipe(sourcemaps.init())
		    .pipe(sass({
		      includePaths: [
		      	paths.npmPath + '/uswds/src/stylesheets',
		        srcPath + '**/*.scss'
		      ],
		      errLogToConsole: true,
		      outputStyle: 'expanded'
		    }))
		    .pipe(postcss([
		      autoprefixer({ browsers: ['last 2 version'] })
		    ]))
		    // .pipe(sourcemaps.write())
		    .pipe(gulp.dest( blockPath ))
		    .pipe(cssnano({ safe: true }));

   });

   return tasks; //merge(tasks, root);
});

/**
 * Compile the JS, this also transpiles to ES5
 */
gulp.task('js', ['clean:js'], function () {
    // app.js is your main JS file with all your module inclusions
    return browserify({entries: paths.srcPath + '/js/manifest.js', debug: true})
    .transform("babelify", { presets: ["es2015"] })
    .bundle()
    .pipe(source('manifest.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(sourcemaps.write('./maps'))
  	.pipe(rename('franklin.js'))
  	.pipe(gulp.dest( paths.assetsPath + '/js' ));
});


/**
 * Remove the old JS files
 */
gulp.task('clean:js', function() {
  return del(
    [ paths.assetsPath + '/js' ],
    {read:false, force: true});
});


// CSS
/**
 * Minify and optimize style.css.
 */
gulp.task('css', ['scss'], function() {

  // removing the red theme for now
  // paths.assetsPath + '/css/benjamin-red.css'
  return gulp.src([
      paths.assetsPath + '/css/manifest.css',
    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(cssnano({ safe: true }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest( paths.assetsPath + '/css'));
});


/**
 * Compile Sass and run stylesheet through PostCSS.
 */
gulp.task('scss', ['clean:css'], function() {

  // removing the red theme for now
  // paths.srcPath+'/scss/benjamin-red.scss'
  return gulp.src([
      paths.srcPath+'/scss/manifest.scss'
    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: [
        paths.scssGlob
      ],
      errLogToConsole: true,
      outputStyle: 'expanded'
    }))
    .pipe(postcss([
      autoprefixer({ browsers: ['last 2 version'] })
    ]))
    .pipe(sourcemaps.write())
    .pipe(rename('franklin.css'))
    .pipe(gulp.dest( paths.assetsPath + '/css' ));
});


gulp.task('clean:css', function() {
  return del(
    [ paths.assetsPath + '/css' ],
    {read:false, force: true});
});


// ---------------------------------------------------------------------------
//  Utilities
// ---------------------------------------------------------------------------

gulp.task('pot', function () {

    return gulp.src('../**/*.php')
        .pipe(wpPot( {
            domain: 'benjamin',
            package: 'Example project'
        } ))
        .pipe(gulp.dest('../languages/benjamin.pot'));
});

/**
 * Handle errors.
 * plays a noise and display notification
 */
function handleErrors() {
  var args = Array.prototype.slice.call(arguments);
  notify.onError({
    title: 'Task Failed [<%= error.message %>',
    message: 'See console.',
    sound: 'Sosumi'
  }).apply(this, args);
  util.beep();
  this.emit('end');
}

/**
 * Builds the JS and SASS
 * @return {[type]} [description]
 */
gulp.task('build', function(){
  gulp.start('js');
  gulp.start('css');
});

/**
 * Default Task, runs build and then watch
 * @return {[type]} [description]
 */
gulp.task('default', function(){
  gulp.start('watch');
});


/**
 * Process tasks and reload browsers.
 */
gulp.task('watch', function() {
  gulp.start('build');
  gulp.watch(paths.jsGlob, ['js']);
  gulp.watch(paths.scssGlob, ['css']);
});


gulp.task('gutenberg_build', function(){
  gulp.start('gutenberg_js');
  gulp.start('gutenberg_css');
});

/**
 * Process tasks and reload browsers.
 */
gulp.task('gutenberg_watch', function() {
  gulp.start('gutenberg_build');
  gulp.watch(paths.gutenbergSrc + '/**/*.js', ['gutenberg_js']);
  gulp.watch(paths.gutenbergSrc + '/**/*.scss', ['gutenberg_css']);
});

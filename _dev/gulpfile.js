'use strict';

var gulp         = require('gulp');
var plugins      = require('gulp-load-plugins')();

var autoprefixer = require('autoprefixer');
var babelify     = require('babelify');
var browserify   = require('browserify');
var buffer       = require('vinyl-buffer');
var cssnano      = require('gulp-cssnano');
var concat       = require('gulp-concat');
var del          = require('del');
var fs           = require('fs');
var util         = require('gulp-util');
var imagemin     = require('gulp-imagemin');
var livereload   = require('gulp-livereload');
var merge        = require('merge-stream');
var minify       = require('gulp-minify');
var notify       = require('gulp-notify');
var path         = require('path');
var plumber      = require('gulp-plumber');
var postcss      = require('gulp-postcss');
var pngquant     = require('imagemin-pngquant');
var rename       = require('gulp-rename');
var requireDir   = require('require-dir');
var sass         = require('gulp-sass');
var source       = require('vinyl-source-stream');
var sourcemaps   = require('gulp-sourcemaps');
var transform    = require('vinyl-transform');
var uglify       = require('gulp-uglify');
var watch        = require('gulp-watch');
var wpPot        = require('gulp-wp-pot');

function getTask(task) {
  console.log('loading' + task)
  return require('./gulp-tasks/' + task)(gulp, plugins, paths);
}


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

function getFolders(dir) {
  return fs.readdirSync(dir)
  .filter(function(file) {
    return fs.statSync(path.join(dir, file)).isDirectory();
  });
}

// dir paths
var paths = {
  srcPath:          './src',
  assetsPath:       '../assets',
  adminSrcPath:     './admin-src',
  adminAssetsPath:  '../inc/admin/assets',
  npmPath :         './node_modules',
  bowerPath:        './bower_components',
  vendorPath:       './js/vendor',
  gutenbergSrc:     './gutenberg',
  gutenbergBuilds:  '../inc/gutenberg/blocks'
};
paths.scssGlob      = paths.srcPath + '/scss/**/*.scss';
paths.jsGlob        = paths.srcPath + '/js/**/*.js';
paths.adminScssGlob = paths.adminSrcPath + '/scss/**/*.scss';
paths.adminJSGlob   = paths.adminSrcPath + '/js/**/*.js';
paths.gutenGlobJS   = paths.gutenbergSrc + '/**/*.js', 
paths.gutenGlobSCSS = paths.gutenbergSrc + '/**/*.scss',


// ---------------------------------------------------------------------------
//  Utilities
// ---------------------------------------------------------------------------


gulp.task('gutenberg_js', function(){
  var folders = getFolders(paths.gutenbergSrc);
  var tasks = folders.map(function(folder) {
    var file = 'block.js';
    var srcPath = paths.gutenbergSrc + '/' + folder + '/js/' + file;
    var blockPath = paths.gutenbergBuilds + '/' + folder;
    
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

  return tasks; 
});


gulp.task('gutenberg_css', function(){
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
 * Build the Javascript
 */
gulp.task('jsClean', function(){
  return del(
    [paths.assetsPath + '/js'],
    {read:false, force: true}
  );
});


gulp.task('js', ['jsClean'], function(){
  const {assetsPath, srcPath } = paths;
  const dest = paths.assetsPath + '/js';
  var files = [
    paths.srcPath + '/js/franklin.js',
    paths.srcPath + '/js/franklin-post-formats.js'
  ];

  const b = babelify.configure({
    presets: ['es2015']
  });

  var built = files.map(function(file){
    return browserify({
      debug: true,
      entries: file,
            transform: [b]
    }).bundle()
    .pipe(source(path.basename(file)))
    .pipe(buffer())
    .pipe(gulp.dest(dest))
    .pipe(uglify())
    .pipe(rename({
        extname: '.min.js'
    }))
    .pipe(gulp.dest(dest));
  });

  return merge(built);
});


/**
 * Build the CSS
 */
gulp.task('css', ['scss'],function(){
  return gulp.src([
    paths.assetsPath + '/css/manifest.css',
  ])
  .pipe(plumber({ errorHandler: handleErrors }))
  .pipe(cssnano({ safe: true }))
  .pipe(rename({suffix: '.min'}))
  .pipe(gulp.dest( paths.assetsPath + '/css'));

});

gulp.task('scss', ['clean:css'], function(){
  return gulp.src([
    paths.srcPath + '/scss/manifest.scss'
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

gulp.task('clean:css', function(){
    return del(
      [ paths.assetsPath + '/css' ],
      {read:false, force: true}
    );
});


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

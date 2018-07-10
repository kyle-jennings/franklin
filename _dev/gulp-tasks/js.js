var babelify     = require('babelify');
var browserify   = require('browserify');
var buffer       = require('vinyl-buffer');
var source       = require('vinyl-source-stream');
var sourcemaps   = require('gulp-sourcemaps');
var transform    = require('vinyl-transform');
var uglify       = require('gulp-uglify');
var rename       = require('gulp-rename');
var merge        = require('merge-stream');
var path         = require('path');


module.exports = function(gulp, paths) {
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
    .pipe(uglify())
    .pipe(rename({
        extname: '.min.js'
    }))
    .pipe(gulp.dest(dest));
  });

  return merge(built);
};


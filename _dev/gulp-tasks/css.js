module.exports = function(gulp, plugins) {

  // removing the red theme for now
  // paths.assetsPath + '/css/benjamin-red.css'
  return gulp.src([
    paths.assetsPath + '/css/manifest.css',
  ])
  .pipe(plumber({ errorHandler: handleErrors }))
  .pipe(cssnano({ safe: true }))
  .pipe(rename({suffix: '.min'}))
  .pipe(gulp.dest( paths.assetsPath + '/css'));

};





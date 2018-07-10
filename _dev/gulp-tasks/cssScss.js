module.exports = function(gulp, plugins) {
  // removing the red theme for now
  // paths.srcPath+'/scss/benjamin-red.scss'
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
};

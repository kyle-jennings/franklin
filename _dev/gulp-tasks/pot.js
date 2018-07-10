module.exports = function(gulp, plugins) {
  return gulp.src('../**/*.php')
  .pipe(wpPot( {
      domain: 'benjamin',
      package: 'Example project'
  } ))
  .pipe(gulp.dest('../languages/benjamin.pot'));

};
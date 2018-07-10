module.exports = function(gulp, plugins) {
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
};

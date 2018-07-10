module.exports = function(gulp, plugins) {
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
};

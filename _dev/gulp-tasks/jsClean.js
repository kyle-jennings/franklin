var del = require('del');

module.exports = function(gulp, plugins, paths) {
  return del(
    [paths.assetsPath + '/js'],
    {read:false, force: true});
};

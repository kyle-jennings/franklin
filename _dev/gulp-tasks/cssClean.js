module.exports = function(gulp, plugins) {
  return del(
    [ paths.assetsPath + '/css' ],
    {read:false, force: true});
};

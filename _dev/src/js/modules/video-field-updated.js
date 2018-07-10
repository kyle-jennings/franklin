$('body').on('change','.js--video-url', function(e){

  var $this = $(this);
  var url = $this.val();
  var $thisParent = $this.closest('.js--media-wrapper');
  var $preview = $thisParent.find('.js--placeholder');
  var settingKey = $this.data('is-customizer') ? $this.data('customize-setting-link') : null;


  window.videoAjax(url, $preview);

  if(settingKey && url ) {

    wp.customize( settingKey, function ( obj ) {
      obj.set( url );
    } );
  }

});

window.videoAjax = function(url, $preview){
  
  var data = {
    "action": "franklin_video_shortcode",
    "data": url
  };

  $.ajax({
    type: 'post',
    url: ajaxurl,
    data: data,
    complete: function(response){
      var output = response.responseText;
      console.log(output);
      $preview.html( output );
    }
  });

};
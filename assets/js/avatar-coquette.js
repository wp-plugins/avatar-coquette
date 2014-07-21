function avatar_coquette_operation(){

    if( jQuery("#avatar_coquette_set_avatar").val() == 1 || ! jQuery("#avatar_coquette_set_avatar").val()  ){

        jQuery(".preview_html2").css("display","none");
        jQuery(".preview_html1").fadeIn();


    }else if( jQuery("#avatar_coquette_set_avatar").val() == 2 ){

        jQuery(".preview_html1").css("display","none");
        jQuery(".preview_html2").fadeIn();

    }else{

        jQuery(".preview_html1").css("display","none");
        jQuery(".preview_html2").css("display","none");

    }
}
jQuery(document).ready(function($){

    avatar_coquette_operation();

    jQuery("#avatar_coquette_enabled_text").on("change",function(){
       if(jQuery(this).is(":checked")) {
          jQuery(".class_coquette_avatar_enable_link").fadeIn();
       }else{
          jQuery(".class_coquette_avatar_enable_link").fadeOut();
       }
    });

    if(jQuery("#avatar_coquette_enabled_text").is(":checked")) {
      jQuery(".class_coquette_avatar_enable_link").fadeIn();
    }else{
      jQuery(".class_coquette_avatar_enable_link").fadeOut();
    }


});


/*
 * Adapted from: http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 */
jQuery(document).ready(function($){
// Uploading files
var file_frame_coquette;
 
  $('.additional-user-image').on('click', function( event ){
 
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame_coquette ) {
      file_frame_coquette.open();
      return;
    }
 
    // Create the media frame.
    file_frame_coquette = wp.media.frames.file_frame_coquette = wp.media({
      title: $( this ).data( 'uploader_title' ),
      button: {
        text: $( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame_coquette.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame_coquette.state().get('selection').first().toJSON();
      //alert( attachment.url );
      //console.log(attachment, "Sam", "100");
      $("#user_meta_image").val( attachment.url );
 
      // Do something with attachment.id and/or attachment.url here
    });
 
    // Finally, open the modal
    file_frame_coquette.open();
  });
 
});
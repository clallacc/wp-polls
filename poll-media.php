<?php

function image_button($id, $img_src=''){
    $name = '';
    if(empty($img_src))
        $img_src = 'https://cdn-icons-png.flaticon.com/512/739/739249.png';
    if(isset($_GET['mode']) && $_GET['mode'] === 'edit'){
        $name = "polla_images_$id";
    }
    else{
        $name = 'polla_images[]';
    }
    $html = sprintf('<img alt="image preview" id="image_preview_%d" src="%s" width="10%%" height="10%%" style="padding: 0 10px;">', $id, $img_src);
    $html .= sprintf('<input id="answer_image_%d" type="text" value="%s" name="%s" hidden/>', $id, $img_src, $name);
    $html .= sprintf('<input id="upload_image_button_%d" type="button" class="button upload_image_button" value="Upload Image" data-id="%d" />', $id, $id);
    return $html;
}

function media_js(){
    echo "<script type='text/javascript'>
        jQuery( document ).ready( function( $ ) {
            console.log('ready');
            // Uploading files
            var file_frame;
            var id;
            var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
            jQuery('tbody').on('click', '.upload_image_button', function( event ){
                event.preventDefault();
                id = $(this).data('id');
                console.log(id);
                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    // Set the post ID to what we want
                    // file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                    // Open frame
                    file_frame.open();
                    return;
                } 
                // else {
                //     // Set the wp.media post id so the uploader grabs the ID we want when initialised
                //     wp.media.model.settings.post.id = set_to_post_id;
                // }
                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select a image to upload',
                    button: {
                        text: 'Use this image',
                    },
                    multiple: false // Set to true to allow multiple files to be selected
                });
                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();
                    console.log(attachment.url);
                    console.log('#answer_image_'+id);
                    $('#answer_image_'+id).attr('value', attachment.url);
                    $('#image_preview_'+id).attr('src', attachment.url);
                });
                    // Finally, open the modal
                    file_frame.open();
            });
            // Restore the main ID when the add media button is pressed
            jQuery( 'a.add_media' ).on( 'click', function() {
                wp.media.model.settings.post.id = wp_media_post_id;
            });
        });
    </script>";
}
?>
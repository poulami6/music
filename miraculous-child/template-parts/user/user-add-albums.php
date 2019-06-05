<?php

$track_image = get_stylesheet_directory_uri().'/images/music_ring.png';
$genres = get_categories('taxonomy=genre&type=ms-albums');
$album_type = get_categories('taxonomy=album-type&type=ms-albums');

?>

<div id="upload-albums" class="content-block my-albums-block">
   <div class="heading-Upload">
      <h2><?php echo esc_html__('Upload Albums', 'miraculous'); ?></h2>
      <form id="upload_artist_albums_form" method="post" enctype="multipart/form-data">
         <fieldset>
            <div class="fields-holder">
               <div class="field-item">
                  <label for="album_name">Album Name</label>
                  <input type="text" name="album_name" id="album_name">
               </div>
               <div class="field-item hide">
                  <label for="album_price">Album price</label>
                  <input type="number" name="album_price" id="album_price">
               </div>
               <div class="field-item">
                  <label for="album_image">Album Image</label>
                  <input type="hidden" name="album_image_id" id="album_image_id" value="">
                  <div class="visual-box">
                     <i class="fa fa-pencil-square-o album_image"></i>
                     <img src="<?php echo $track_image;?>" alt="photo" width="160" height="192" id="album_image-preview" class="img-fluid">
                  </div>
               </div>
            </div>
            <div class="field-item">
               <label for="description">Album Description</label>
               <textarea id="description" name="description" cols="30" rows="5"></textarea>
            </div>
            <div class="field-item">
               <p class="useralbumsupload">Album Genres</p>
               <?php if(!empty($genres)){
                  foreach ($genres as $genre_key => $genre) {
                  ?>
               <label class="checkbox-inline">
               <input type="checkbox" name="album_genres[]" value="<?php echo $genre->slug;?>" id="album_genres_<?php echo $genre_key;?>" class="form-control album_genres"><?php echo $genre->name;?>
               </label>
               <?php
                  }
                  }
                  ?>
            </div>
            
            <div class="decor-heading">
               <h3><?php echo esc_html__('MUSIC DETAILS', 'miraculous'); ?></h3>
            </div>
            <div class="fields-holder">
               <div class="col-md-12" >
                  <table id="imageUploadSection">
                     <thead>
                        <th>Song Name</th>
                        <th>Song Image</th>
                        <th>File</th>
                     </thead>
                     <tbody>
                        <tr id="field0">
                           <td><input type="text" name="song_title[]" id="song_title-0" class="form-control"></td>
                           <td> 
                              
                              <input type="hidden" name="song_image_id[]" id="song_image_id-s0" value="">
                              
                              <div class="visual-box">
                              <i class="fa fa-pencil-square-o select_song_image" id="s0"></i>
                                <img src="<?php echo $track_image;?>" alt="photo" width="50" height="50" id="song_image-preview-s0" class="img-fluid">
                              </div>
                           </td>
                           <td>
                              <input type="hidden" name="song_file_id[]" id="song_file_id-f0" value="">
                              <input type="hidden" name="file_url[]" id="file_url-f0" value="">
                              <input type="hidden" name="full_file_data[]" id="full_file_data-f0" value="">
                              
                              <div class="visual-box">
                              <i class="fa fa-pencil-square-o select_song_file" id="f0"></i>
                                <img src="<?php echo $track_image;?>" alt="photo" width="50" height="50" id="song_file-preview-f0" class="img-fluid">
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <!-- Button -->
                  <div class="form-group">
                     <div class="col-md-4">
                        <button id="add-more-music" name="add-more" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="buttons-row">
               <button class="hst_loader"><i class="fa fa-circle-o-notch fa-spin"></i> Loading</button>
               <input type="reset" name="reset_form" class="ms_btn" value="reset">
               <div class="btn-box">
                  <input type="submit" id="upload_submit" value="Submit" class="button">
               </div>
            </div>
         </fieldset>
      </form>
   </div>
</div>

   <script type="text/javascript">
    
    $(document).ready(function () {
    var next = 0;
    $("#add-more-music").click(function(e){
        e.preventDefault();

        var imagepreview = '<?php echo $track_image;?>';

        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<tr id="field'+next+'"><td><input type="text" name="song_title[]" id="song_title-'+next+'" class="form-control"></td><td><input type="hidden" name="song_image_id[]" id="song_image_id-s'+next+'" value=""><div class="visual-box"><i class="fa fa-pencil-square-o select_song_image" id="s'+next+'"></i><img src="'+imagepreview+'" alt="photo" width="50" height="50" id="song_image-preview-s'+next+'" class="img-fluid"></div></td><td><input type="hidden" name="song_file_id[]" id="song_file_id-f'+next+'" value=""><input type="hidden" name="file_url[]" id="file_url-f'+next+'" value=""><input type="hidden" name="full_file_data[]" id="full_file_data-f'+next+'" value=""><div class="visual-box"><i class="fa fa-pencil-square-o select_song_file" id="f'+next+'"></i><img src="'+imagepreview+'" alt="photo" width="50" height="50" id="song_file-preview-f'+next+'" class="img-fluid"></div></td>';

        var newInput = $(newIn);
        var removeBtn = '<button id="music-remove' + (next - 1) + '" class="btn btn-danger remove-add-more-music" ><i class="fa fa-times" aria-hidden="true"></i></button></tr>';

        var removeButton = $(removeBtn);
        
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-add-more-music').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });

            initCustomForms();
    });

});

  </script>
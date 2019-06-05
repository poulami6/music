(function($) {
    "use strict";
	jQuery(document).ready(function($){

	  var edit_profile_mediaUploader;
	  var mp3_select_mediaUploader;
	  var artist_mediaUploader;
	  var mediaUploader;

	  $('.img_edit_plus').on('click',function(e) {
		e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		  if (edit_profile_mediaUploader) {
		  edit_profile_mediaUploader.open();
		  return;
		}
		// Extend the wp.media object
		edit_profile_mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Image',
		  button: {
		  text: 'Choose Image'
		},
		library: {
			type: 'image'
		  }, multiple: false });

		// When a file is selected, grab the URL and set it as the text field's value
		edit_profile_mediaUploader.on('select', function() {
		  var attachment = edit_profile_mediaUploader.state().get('selection').first().toJSON();
		  $('#img-preview').attr('src', attachment.url);
		  $('#image-url').val(attachment.url);
		});
		// Open the uploader dialog
		edit_profile_mediaUploader.open();
	  });

	  $('.mp3_file_upload').on('click',function(e) {
		e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		  if (mp3_select_mediaUploader) {
		  mp3_select_mediaUploader.open();
		  return;
		}
		// Extend the wp.media object
		mp3_select_mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose mp3',
		  button: {
			text: 'Choose mp3'
		  },
		  library: {
			type: 'audio'
		  },
		  multiple: false });

		// When a file is selected, grab the URL and set it as the text field's value
		mp3_select_mediaUploader.on('select', function() {
		  var attachment = mp3_select_mediaUploader.state().get('selection').first().toJSON();
		  var fulltext = JSON.stringify(attachment);
		  var text = 'Title: '+attachment.title+'<br>File Name: '+attachment.filename+'<br>Length: '+attachment.fileLength+'<br>Size: '+attachment.filesizeHumanReadable;
		  $('#ms_audio_file').html(text);
		  $('#up_track_mp3').val(attachment.url);
		  $('#up_track_mp3_id').val(attachment.id);
		  $('#up_full_track_data').val(fulltext);
		});
		// Open the uploader dialog
		mp3_select_mediaUploader.open();
	  });

		$('.up_image_upload').on('click',function(e) {
		e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		  if (mediaUploader) {
		  mediaUploader.open();
		  return;
		}
		// Extend the wp.media object
		mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Image',
		  button: {
		  text: 'Choose Image'
		},
		library: {
			type: 'image'
		  },
		multiple: false });

		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader.on('select', function() {
		  var attachment = mediaUploader.state().get('selection').first().toJSON();
		  $('#up_image_file').val(attachment.url);
		  $('#up_image_file_id').val(attachment.id);
		});
		// Open the uploader dialog
		mediaUploader.open();
	  });

	  $('.up_artists_image').on('click',function(e) {
		e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		  if (artist_mediaUploader) {
		  artist_mediaUploader.open();
		  return;
		}
		// Extend the wp.media object
		artist_mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Image',
		  button: {
		  text: 'Choose Image'
		},
		library: {
			type: 'image'
		  },
		multiple: false });

		// When a file is selected, grab the URL and set it as the text field's value
		artist_mediaUploader.on('select', function() {
		  var attachment = artist_mediaUploader.state().get('selection').first().toJSON();
		  $('#new_artist_image').val(attachment.url);
		  $('#new_artist_image_id').val(attachment.id);
		});
		// Open the uploader dialog
		artist_mediaUploader.open();
	  });
	});
})(jQuery);
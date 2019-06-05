(function($) {
	"use strict";
	
	$("#form_register").on('submit', function(e){
		e.preventDefault();
		var username = $("#username").val();
		var full_name = $("#full_name").val();
		var useremail = $("#useremail").val();
		var password = $("#password").val();
		var confirmpass = $("#confirmpass").val();
		var emptyfield = false;
		var emailvalid = false;
		var passvalid = false;
		toastr.clear();

		if( username == '' ) {
			emptyfield = true;
		}
		if(full_name == '') {
			emptyfield = true;
		}
		if(useremail == '') {
			emptyfield = true;
		}
		if(password == '') {
			emptyfield = true;
		}
		if(confirmpass == '') {
			emptyfield = true;
		}

		if(emptyfield == false) {
			if ( validateEmail(useremail) ) {
				emailvalid = true;
			}else {
				emailvalid = false;
				toastr.error('Email is not valid.');
	        }

	        if(password == confirmpass){
	        	passvalid = true;
	        }else{
	        	passvalid = false;
	        	toastr.error('password does not match.');
	        }

		}else{
			$(".form-msg").addClass('error-row');
			toastr.error('All fields are required.');
		}

		if(passvalid == true && emailvalid == true) {
			var formdata ='username='+username+'&full_name='+full_name+'&useremail='+useremail+'&password='+password+'&confirmpass='+confirmpass;
				formdata += '&action=miraculous_user_register_form';

				$("#erroremail").html('');
				$("#errorcpass").html('');
				$("#register_btn").hide();
				$(".hst_loader").show();
				$(".form-msg").html('');
				$.ajax({
					type: 'post',
					url: frontadminajax.ajax_url,
					data: formdata,
					success: function(response){
						var result = JSON.parse(response);
						if( result.status == 'true' ) {
							$(".form-msg").addClass('success-row');
							toastr.success(result.msg);
							$("#form_register")[0].reset();
							$("#myModal").modal("hide");
							$("#myModal1").modal("show");
						}else{
							$.each(result, function(i,n){
							    if(n != 'false'){
							        toastr.error(n);   
							    }
							});
						}

						$(".hst_loader").hide();
						$("#register_btn").show();

					}
				});
		}


	});

	$("input").on('keyup',function(){
        $(this).siblings(".error-row").html('');
        $(".form-msg").html('');
        $(".form-lmsg").html('');
    });
    $( ".change_pass" ).on('click',function() {
      $( ".change_password_slide" ).slideToggle( "slow" );
      $("#ed_password").val("");
      $("#ed_confpassword").val("");
    });
    
    $(".ms_add_playlist").on('click', function(){
    	var music = $(this).attr("data-msmusic");
    	$("#ms_share_music_modal_id").modal("hide");
    	$("#create_playlist_modal").modal("hide");
    	$('#add_in_playlist_modal select[name="playlistname"]').attr("data-msmusic", music);
    	$("#add_in_playlist_modal").modal("show");
    });
    $(".ms_create_playlist").on('click', function(){
    	$("#add_in_playlist_modal").modal("hide");
    	$("#create_playlist_modal").modal("show");
    });

    $(".ms_share_music").on('click', function(){
        var share_uri = $(this).attr('data-shareuri');
    	var share_title = $(this).attr('data-sharename');
    	$("#add_in_playlist_modal").modal("hide");
    	$("#create_playlist_modal").modal("hide");
    	
        if (window.innerWidth <= 640) {
    	    $(".ms_share_facebook").attr('href', 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(share_uri));
    	    $(".ms_share_linkedin").attr('href', 'https://www.linkedin.com/cws/share?url='+encodeURIComponent(share_uri));
    	    $(".ms_share_twitter").attr('href', 'https://twitter.com/intent/tweet?text='+share_title+'&amp;url='+encodeURIComponent(share_uri)+'&amp;via=Miraculous');
    	    $(".ms_share_googleplus").attr('href', 'https://plus.google.com/share?url='+encodeURIComponent(share_uri));
        }
        else {
            var width = 200;
            var height = 150;
            $(".ms_share_facebook").attr('onclick', "window.open('https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(share_uri)+"', 'Share', width='" + width + "', height='" + height + "' )");
            $(".ms_share_linkedin").attr('onclick', "window.open('https://www.linkedin.com/cws/share?url="+encodeURIComponent(share_uri)+"', 'Share', width='" + width + "', height='" + height + "' )");
            $(".ms_share_twitter").attr('onclick', "window.open('https://twitter.com/intent/tweet?text="+share_title+"&url="+encodeURIComponent(share_uri)+"&via=Miraculous' , 'Share', width='" + width + "', height='" + height + "' )");
            $(".ms_share_googleplus").attr('onclick', "window.open('https://plus.google.com/share?url="+encodeURIComponent(share_uri)+"', 'Share', width='" + width + "', height='" + height + "' )");
        }
    	
    	$("#ms_share_music_modal_id").modal("show");
    });

	$("#form_login").on('submit', function(e){
	e.preventDefault();
	var username = $("#lusername").val();
	var password = $("#lpassword").val();
	var rem = $('#rem_check').val();
    toastr.clear();
		if(username == '' && password == ''){
			$(".form-lmsg").addClass('error-row');
			toastr.error('All fields are required.');
		}else{
			var formdata ='username='+username+'&password='+password+'&rem_check='+rem;
			formdata += '&action=miraculous_user_login_form';

			$("#login_btn").hide();
			$(".hst_loader").show();
			$(".form-lmsg").html('');
			$.ajax({
				type: 'post',
				url: frontadminajax.ajax_url,
				data: formdata,
				success: function(response){
					var result = JSON.parse(response);
					if( result.status == 'false' ) {
						$(".form-lmsg").addClass('error-row');
						toastr.error(result.msg);
					}else{
					    toastr.success(result.msg);
						window.location.href = result.redirect_uri;
					}
					
					$(".hst_loader").hide();
					$("#login_btn").show();

				}
			});
		}

	});
	
	$("#newsletter_form").on('submit', function(e){
		e.preventDefault();

		var username = $("#ns_user").val();
		var user_email = $("#ns_email").val();

		if( username == '' && user_email == '' ) {
			$(".ns_form_msg").addClass('error-row');
			$(".ns_form_msg").html('* fields are required!!');
		}
		else if( username == '' ){
			$(".ns_form_msg").addClass('error-row');
			$(".ns_form_msg").html('* Name is required!!');
		}
		else{
			var formdata ='ns_name='+username+'&ns_email='+user_email;
			formdata += '&action=miraculous_user_newsletter_form';

			$("#newsletter_sign").hide();
			$(".hst_loader").show();
			$(".ns_form_msg").html('');
			$.ajax({
					type: 'post',
					url: frontadminajax.ajax_url,
					data: formdata,
					success: function(response){
						var result = JSON.parse(response);
						if( result.status == 'success' ) {
							$(".ns_form_msg").addClass('success-row');
							$(".ns_form_msg").html(result.msg);
							$("#newsletter_form")[0].reset();
						}else if( result.status == 'error' ){
							$(".ns_form_msg").addClass('error-row');
							$(".ns_form_msg").html(result.msg);
						} else{
							$(".ns_form_msg").addClass('error-row');
							$(".ns_form_msg").html( 'Some problem occurred, please try again.' );
						}

						$(".hst_loader").hide();
						$("#newsletter_sign").show();
					}
				});
		}

	});

   function validateEmail(uemail) {
	    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	    if (filter.test(uemail)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}

	$("#upload_music_form").on('submit', function(e){
		e.preventDefault();
		var mp3_file = $("#up_track_mp3").val();
		var full_track = $("#up_full_track_data").val();
		var track_name = $("#up_track_name").val();
		var artists_name = $("#up_artists_name").val();
		var language_id = $("#up_language_id").val();
		var privacy = $("#up_privacy_name").val();
		var image = $("#up_image_file").val();
		var attachimage_id = $("#up_image_file_id").val();
		var up_track_mp3_id = $("#up_track_mp3_id").val();

		if(mp3_file == '' ){
			toastr.error('Please upload mp3 file.');
			return;
		}
		if(track_name == '' ){
			toastr.error('Please enter track name.');
			return;
		}
		if(artists_name == '' ){
			toastr.error('Please enter artist name.');
			return;
		}
		if(image == '' ){
			toastr.error('Please upload music image.');
			return;
		}
		$("#upload_submit").hide();
		$(".hst_loader").show();

		var formdata ='mp3_url='+mp3_file+'&track_mp3_id='+up_track_mp3_id+'&full_track='+full_track+'&track_name='+track_name+'&artists_name='+artists_name+'&language_id='+language_id+'&privacy='+privacy+'&music_image='+image+'&attachimage_id='+attachimage_id;
			formdata += '&action=miraculous_user_music_upload';
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				if(result.status == 'true'){
				    $("#upload_music_form")[0].reset();
					$("#up_track_mp3").val('');
					$("#up_full_track_data").val('');
					$("#ms_audio_file").html('');
				    if(result.track_page != ''){
				        window.location.href = result.track_page;
				    }
				}
				toastr.success(result.msg);
				$(".hst_loader").hide();
				$("#upload_submit").show();
			}
		});
	});
	
	$("#artist_create_form").on('submit', function(){
		var artist_name = $("#new_artist_name").val();
		var artist_image = $("#new_artist_image").val();

		if(artist_name == ''){
			toastr.error('Please enter artist name.');
			return false;
		}
		if(artist_image == ''){
			toastr.error('Please upload or select image.');
			return false;
		}
	});

	$(".ms_download").on('click', function(){
		var id = $(this).attr('data-msmusic');

		var formdata ='musicid='+id;
			formdata += '&action=miraculous_music_download';
        $(".ms_ajax_loader").show();
		if(id){
			$.ajax({
				type: 'post',
				url: frontadminajax.ajax_url,
				data: formdata,
				success: function(response){
					var result = JSON.parse(response);
					$(".ms_ajax_loader").hide();
					if( result.status == 'success' && result.mp3_uri != '' ) {
						var link = document.createElement("a");
						    link.download = result.mp3_name;
						    link.href = result.mp3_uri;
						    link.click();
					}else{
						if(result.status == 'false' && result.plan_page != ''){
						    window.location.href = result.plan_page;
						}else{
							toastr.error(result.msg);
						}
					}
				}
			});
		}else{
			toastr.error("Something went wrong on file.");
		}
		
	});

	$(".favourite_music").on('click', function(){
		var sid = $(this).attr('data-musicid');
		var cur_ev = $(this);
		var formdata ='songid='+sid;
			formdata += '&action=miraculous_add_in_favourites_songs_list';
			
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
				    if(result.action == 'removed'){
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav_add');
				        $(cur_ev).find('span.icon').addClass('icon_fav');
				    }else{
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav');
				        $(cur_ev).find('span.icon').addClass('icon_fav_add');
				    }
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".remove_favourite_music").on('click', function(){
		var sid = $(this).attr('musicid');
		var formdata ='songid='+sid;
			formdata += '&action=miraculous_remove_from_favourites_songs_list';
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					$("a[musicid='"+sid+"']").parent().parent('ul').slideUp("slow", function() { $(this).remove();});
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".remove_user_playlist_music").on('click', function(){
		var sid = $(this).attr('musicid');
		var playlist = $(this).attr('data-list');
		var formdata ='songid='+sid+'&playlist='+playlist;
			formdata += '&action=miraculous_remove_from_user_playlist_songs_list';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					$("a[musicid='"+sid+"']").parent().parent('ul').slideUp("slow", function() { $(this).remove();});
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});
	
	$(".ms_remove_user_playlist").on('click', function(){
		var playlist = $(this).attr('data-list');
		var formdata ='playlist='+playlist;
			formdata += '&action=miraculous_remove_user_playlist';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
				    location.reload();
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".remove_premium_music").on('click', function(){
		var sid = $(this).attr('musicid');
		var formdata ='songid='+sid;
			formdata += '&action=miraculous_remove_from_premium_songs_list';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					$("a[musicid='"+sid+"']").parent().parent('ul').slideUp("slow", function() { $(this).remove();});
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".remove_free_music").on('click', function(){
		var sid = $(this).attr('musicid');
		var formdata ='songid='+sid;
			formdata += '&action=miraculous_remove_from_free_songs_list';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					$("a[musicid='"+sid+"']").parent().parent('ul').slideUp("slow", function() { $(this).remove();});
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".ms_remove_history_music").on('click', function(){
		var mid = $(this).attr('data-musicid');
		var curt = $(this);
		var formdata ='songid='+mid;
			formdata += '&action=miraculous_remove_history_music_action';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
				    /*location.reload();*/
				    $(curt).parents('.col-lg-2').remove();
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".favourite_albums").on('click', function(){
		var abid = $(this).attr('data-albumid');
		var cur_ev = $(this);
		var formdata ='albumid='+abid;
			formdata += '&action=miraculous_add_in_favourites_albums_list';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					if(result.action == 'removed'){
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav_add');
				        $(cur_ev).find('span.icon').addClass('icon_fav');
				    }else{
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav');
				        $(cur_ev).find('span.icon').addClass('icon_fav_add');
				    }
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".favourite_radios").on('click', function(){
		var abid = $(this).attr('data-radioid');
		var cur_ev = $(this);
		var formdata ='radioid='+abid;
			formdata += '&action=miraculous_add_in_favourites_radios_list';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					if(result.action == 'removed'){
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav_add');
				        $(cur_ev).find('span.icon').addClass('icon_fav');
				    }else{
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav');
				        $(cur_ev).find('span.icon').addClass('icon_fav_add');
				    }
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".favourite_artist").on('click', function(){
		var arid = $(this).attr('data-artistid');
		var cur_ev = $(this);
		var formdata ='artistid='+arid;
			formdata += '&action=miraculous_add_in_favourites_artists_list';
        
        $(".ms_ajax_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				$(".ms_ajax_loader").hide();
				if( result.status == 'success' ) {
					if(result.action == 'removed'){
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav_add');
				        $(cur_ev).find('span.icon').addClass('icon_fav');
				    }else{
				        toastr.success(result.msg);
				        $(cur_ev).find('span.icon').removeClass('icon_fav');
				        $(cur_ev).find('span.icon').addClass('icon_fav_add');
				    }
				}else{
					toastr.error(result.msg);
				}
			}
		});
	});

	$(".create_new_playlist").on('click', function(){
		var name = $("#playlist_name").val();
		if(name == ''){
			toastr.error("Please enter name of playlist.");
		}else{
			var formdata ='playlistname='+name;
				formdata += '&action=miraculous_create_new_user_playlist';
			$(".create_new_playlist").hide();
			$(".hst_loader").show();
			$.ajax({
				type: 'post',
				url: frontadminajax.ajax_url,
				data: formdata,
				success: function(response){
					var result = JSON.parse(response);
					if( result.status == 'success' ) {
						location.reload();
						toastr.success(result.msg);
					}else{
						toastr.error(result.msg);
						$(".hst_loader").hide();
						$(".create_new_playlist").show();
					}
				}
			});
		}
		
	});

	$(".ms_add_in_playlist").on('click', function(){
		var key = $('#add_in_playlist_modal select[name="playlistname"]').val();
		var musicid = $('#add_in_playlist_modal select[name="playlistname"]').attr('data-msmusic');

		var formdata ='key='+key+'&musicid='+musicid;
			formdata += '&action=miraculous_add_music_in_user_playlist';

		$(".ms_add_in_playlist").hide();
        $(".hst_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: formdata,
			success: function(response){
				var result = JSON.parse(response);
				if( result.status == 'success' ) {
					$("#add_in_playlist_modal").modal("hide");
					toastr.success(result.msg);
				}else{
					toastr.error(result.msg);
				}
				$(".hst_loader").hide();
				$(".ms_add_in_playlist").show();
			}
		});
		
	});
		
	$("#ms_profile_edit").on('submit', function(e){
		e.preventDefault();
		var username = $("#ed_username").val();
		var useremail = $("#ed_useremail").val();
		var userid = $("#cur_user_id").val();
		var pro_img = $("#image-url").val();
		var password = $("#ed_password").val();
		var confpassword = $("#ed_confpassword").val();

		var emptyfield = false;
		var emailvalid = false;
		var passvalid = false;

		if( username == '' ) {
			emptyfield = true;
		}
		if(useremail == '') {
			emptyfield = true;
		}
		if(password == '' && confpassword == ''){
			passvalid = true;
		}

		if(emptyfield == false) {
			if ( validateEmail(useremail) ) {
				emailvalid = true;
			}else {
				emailvalid = false;
	    		toastr.warning("Email is not valid.");
	        }
	        if(password == confpassword){
	        	passvalid = true;
	        }else{
	        	passvalid = false;
	        	toastr.warning("password does not match");
	        }

		}else{
			toastr.error("All fields are required.");
		}

		if(emailvalid == true && passvalid == true) {
			var formdata = 'userid='+userid+'&username='+username+'&useremail='+useremail+'&profile_img='+pro_img+'&password='+password+'&confpassword='+confpassword;
				formdata += '&action=miraculous_user_update_form';

				$("#ms_profile_update").hide();
				$(".hst_loader").show();
				$.ajax({
					type: 'post',
					url: frontadminajax.ajax_url,
					data: formdata,
					success: function(response){
						var result = JSON.parse(response);
						if(result.status == 'false'){
							toastr.error(result.msg);
						}else{
							toastr.success(result.msg);
						}
						$(".hst_loader").hide();
						$("#ms_profile_update").show();

					}
				});
		}	

	});

	$(".language_filter").on('click', function(){
		var lang = [];
		$(".lang_filter:checked").each(function() {
		       lang.push(this.value);
		   });
		var lang_data = 'filter_lang='+lang;
				lang_data += '&action=miraculous_filter_music_language';

		$(".language_filter").hide();
		$(".hst_loader").show();
		$.ajax({
			type: 'post',
			url: frontadminajax.ajax_url,
			data: lang_data,
			success: function(response){
				window.location.href = response;
				$(".hst_loader").hide();
				$(".language_filter").show();

			}
		});
	});
	
	$(".mv_editplaylist").on('click', function(){
	    $("#update_playlist_modal").modal("show");
	});
	
})(jQuery);
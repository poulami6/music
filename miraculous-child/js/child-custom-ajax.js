(function($) {
    "use strict";

      var edit_profile_mediaUploader;
      
      $('.child_img_edit_plus').on('click',function(e) {
        
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
           type: ['image'],

          }, multiple: false });

        // When a file is selected, grab the URL and set it as the text field's value
        edit_profile_mediaUploader.on('select', function() {
          var attachment = edit_profile_mediaUploader.state().get('selection').first().toJSON();
          $('#img-preview').attr('src', attachment.url);
          $('#image-url').val(attachment.url);
          $('#image-id').val(attachment.id);
        });
        // Open the uploader dialog
        edit_profile_mediaUploader.open();
      });

      // for upload image for artist
      $('.album_image').on('click',function(e) {
        e.preventDefault();
       
        if (edit_profile_mediaUploader) {
          edit_profile_mediaUploader.open();
          return;
        }
       
        edit_profile_mediaUploader = wp.media.frames.file_frame = wp.media({
          title: 'Choose Image',
          button: {
          text: 'Choose Image'
        },
        library: {
            type: 'image'
          }, multiple: false });

        
        edit_profile_mediaUploader.on('select', function() {
          var attachment = edit_profile_mediaUploader.state().get('selection').first().toJSON();
          $('#album_image-preview').attr('src', attachment.url);
          $('#album_image_id').val(attachment.id);
        });
        // Open the uploader dialog
        edit_profile_mediaUploader.open();
      });


      // for upload music image for artist

      var edit_artist_music_image_mediaUploader;

    $('#imageUploadSection').on('click','.select_song_image',function(e) {
        e.preventDefault();
       
       var spaceholderid = $(this).attr('id');


        // if (edit_artist_music_image_mediaUploader) {
        //   edit_artist_music_image_mediaUploader.open();
        //   return;
        // }


        edit_artist_music_image_mediaUploader = wp.media.frames.file_frame = wp.media({
          title: 'Choose Image',
          button: {
          text: 'Choose Image'
        },
        library: {
            type: 'image'
          }, multiple: false });

 

        edit_artist_music_image_mediaUploader.on('select', function() {
          var attachment = edit_artist_music_image_mediaUploader.state().get('selection').first().toJSON();

          $('#imageUploadSection #song_image-preview-'+spaceholderid).attr('src', attachment.url);
          $('#imageUploadSection #song_image_id-'+spaceholderid).val(attachment.id);
           edit_artist_music_image_mediaUploader.close();
            
    });
        // Open the uploader dialog
        edit_artist_music_image_mediaUploader.open();
      });

      // for upload music file for artist
      var mp3_select_mediaUploader;

    $('#imageUploadSection').on('click','.select_song_file',function(e) {
        e.preventDefault();
        var fileid = $(this).attr('id');
        // If the uploader object has already been created, reopen the dialog
        // if (mp3_select_mediaUploader) {
        //   mp3_select_mediaUploader.open();
        //   return;
        // }
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
          $('#song_file_id-'+fileid).val(attachment.id);
          $('#file_url-'+fileid).val(attachment.url);
          $('#full_file_data-'+fileid).val(fulltext);
          
        });
        // Open the uploader dialog
        mp3_select_mediaUploader.open();
    });
    


    /*############### for #############################*/
    $('.artist-biography').on('click',function(){
        $('a[href="#tab-biography"]').click();
        $("#tab-biography").slideDown();
    });
    

    /* for email validation */

    function validateEmail(uemail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(uemail)) {
            return true;
        }else {
            return false;
        }
    }

    /* for user registration  */
    $("#user_form_register").on('submit', function(e){
        
        e.preventDefault();
        var username = $("#username1").val();
        var full_name = $("#full_name").val();
        var last_name = $("#last_name").val();
        var who_i_am = $('input[name=who-i-am]:checked').val();
        var useremail = $("#useremail").val();
        var password = $("#password1").val();
        var confirmpass = $("#confirmpass").val();


        var emptyfield = false;
        var emailvalid = false;
        var passvalid = false;
        toastr.clear();

        var user_genres = [];
        $('input.user_genres:checkbox:checked').each(function () {
            user_genres.push($(this).val());
        });


        if( username == '' ) {
            emptyfield = true;
        }
        if(full_name == '') {
            emptyfield = true;
        }
        if(last_name == '') {
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
        if(user_genres == '') {
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
            var formdata ='username='+username+'&full_name='+full_name+'&last_name='+last_name+'&useremail='+useremail+'&password='+password+'&confirmpass='+confirmpass;
                formdata += '&user_genres='+user_genres;
                formdata += '&who_i_am='+who_i_am;
                formdata += '&action=miraculous_child_user_register_form';
                

                $("#erroremail").html('');
                $("#errorcpass").html('');
                $("#register_one1").hide();
                $(".hst_loader").show();
                $(".form-msg").html('');
                $.ajax({
                    type: 'post',
                    url: front_ajax.ajax_url,
                    data: formdata,
                    success: function(response){
                        var result = JSON.parse(response);
                        if( result.status == 'true' ) {
                            $(".form-msg").addClass('success-row');
                            toastr.success(result.msg);
                            $("#user_form_register")[0].reset();
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
                        $("#register_one1").show();

                    }
                });
        }

    });

     /* for user login  */
    $("#child_form_login").on('submit', function(e){
        e.preventDefault();
        var username = $("#lusername").val();
        var password = $("#lpassword").val();
        var redirect_url = $("#redirect_url").val();
        var rem = $('#rem_check').val();
        toastr.clear();

        if(username == '' && password == ''){
            $(".form-lmsg").addClass('error-row');
            toastr.error('All fields are required.');
        }else{
            var formdata ='username='+username+'&password='+password+'&rem_check='+rem+'&rem_check='+rem;
            formdata += '&action=chiild_miraculous_user_login_form';

            $("#login_one1").hide();
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
                        $("#login_one1").show();
                    }else{
                        toastr.success(result.msg);
                        //window.location.href = result.redirect_uri;
                        window.location.href = redirect_url;
                        
                    }
                    
                    $(".hst_loader").hide();
                    

                }
            });
        }

    });

    /*############ for profile edit #########*/
    $("#child_profile_edit").on('submit', function(e){
        e.preventDefault();
        
        var pro_img = $("#image-url").val();
        var pro_img_id = $("#image-id").val();
        var first_name = $("#first_name").val();
        var description = $("#user-description").val();
        var user_gender = $("input[type='radio'].user_gender:checked").val();
        var country = $("#input-country").val();
        var user_genres = [];
        $('input.user_genres:checkbox:checked').each(function () {
            user_genres.push($(this).val());
        });

        var change_pass = $("#change_pass:checked").val();
        var old_password = $("#old_password").val();
        var password = $("#ed_password").val();
        var confpassword = $("#ed_confpassword").val();

        
        var emptyfield = false;
        var passvalid = false;

        if( first_name == '' ) {
            emptyfield = true;
        }
        if(description == '') {
            emptyfield = true;
        }
        if(user_gender == 'male' || user_gender == 'female') {
            emptyfield = false;
        }else{
           emptyfield = true; 
        }
        if(country == '') {
            emptyfield = true;
        }
        if(user_genres == '') {
            emptyfield = true;
        }

        if(change_pass == 'on'){
            //alert("hello");

            if(old_password == '') {
                passvalid = false;
                toastr.error("old password can't be blank" );
                return false;;
            }
            /*if(old_password == password) {
                passvalid = false;
                toastr.error("old password is same as new password" );
                return false;;
            }*/
            if(password == '') {
                emptyfield = true;
            }
            if(confirmpass == '') {
                emptyfield = true;
            }
            
            if(password == confpassword){
                passvalid = true;
            }else{
                passvalid = false;
                toastr.error('password does not match.');
                return false;
            } 
        }
        else{
            passvalid = true;
        }
        
        

        if(emptyfield == false && passvalid == true) {
            var formdata = 'first_name='+first_name+'&description='+description+'&user_gender='+user_gender+'&profile_img='+pro_img+'&profile_img_id='+pro_img_id+'&old_password='+old_password+'&password='+password+'&country='+country+'&user_genres='+user_genres;
                formdata += '&action=child_miraculous_user_update_form';

                $("#ms_profile_update").hide();
                $(".ms_ajax_loader").show();

                $.ajax({
                    type: 'post',
                    url: front_ajax.ajax_url,
                    data: formdata,
                    success: function(response){
                        $(".ms_ajax_loader").hide();
                        var result = JSON.parse(response);
                        if(result.status == 'false'){
                            toastr.error(result.msg);
                        }else{
                            toastr.success(result.msg);
                        }

                        $("#ms_profile_update").show();

                    }
                });
        }else{
            toastr.error("All fields are required.");
        }   

    });

    /* for user follow unfollow  */
    $("#user-follow").on('click', function(){
        
        var fid = $(this).attr('data-follow');
        var cur_ev = $(this);
        var formdata ='fid='+fid;
            formdata += '&action=user_follow_unfollow';
            
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    if(result.action == 'removed'){
                        toastr.success(result.msg);
                        $("#user-follow").removeClass('icon_unfollow');
                        $("#user-follow").addClass('icon_follow');
                        $("#user-follow").text('Follow');
                    }else{
                        toastr.success(result.msg);
                        $("#user-follow").removeClass('icon_follow');
                        $("#user-follow").addClass('icon_unfollow')
                        $("#user-follow").text('Unfollow');
                    }
                    $("#followers-count").text(result.followers);
                    //alert(result.followers);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

$("#user-profile-edit").hide();
$("#profile-edit-button").click(function(){
    $("#user-profile-view").hide();
    $(".additional-info-block").hide();
    $("#user-profile-edit").show();
  });

// $("#user-profile-view-back1").click(function(){
//     $("#user-profile-view").show();
//     $("#user-profile-edit").hide();
//   });


// remove user playlist
    $(".delete_user_playlist_music").on('click', function(){
        var sid = $(this).attr('musicid');
        var playlist = $(this).attr('data-list');
        var formdata ='songid='+sid+'&playlist='+playlist;
            formdata += '&action=child_miraculous_remove_from_user_playlist_songs_list';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    
                    $(".musicid-"+sid).hide();
                    
                    $('.totla_song_'+playlist).text(result.total_song+' Songs');

                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });


    

   // download pagination from user download song
    $(".download-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#download_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');

        var formdata ='offset='+offset+'&limit='+limit;
            formdata += '&action=child_miraculous_download_song_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#download-content").html(response);
                $('.paging').find('.download-pagination').removeClass("current");
                $('#download_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    }); 

     // Artist pagination from user favorites song
    $(".artist-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#artist_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');

        var formdata ='offset='+offset+'&limit='+limit;
            formdata += '&action=child_miraculous_favorites_artist_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#artist-content").html(response);
                initAccordion();
                $('.paging').find('.artist-pagination').removeClass("current");
                
                $('#artist_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });


   // albums pagination from user favorites song
    $(".albums-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#albums_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');

        var formdata ='offset='+offset+'&limit='+limit;
            formdata += '&action=child_miraculous_favorites_albums_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#albums-content").html(response);
                initAccordion();
                $('.paging').find('.albums-pagination').removeClass("current");
                
                $('#album_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });
    // song pagination from user favorites song
    $(".song-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#song_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');


        var formdata ='offset='+offset+'&limit='+limit;
            formdata += '&action=child_miraculous_favorites_playlist_songs_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {

                    $("#song-content").html(result.songs);
                    $('.paging').find('.song-pagination').removeClass("current");
                    $('#song_pagin_'+ pagin).addClass( 'current' );

                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    // Radio pagination from user favorites radios
    $(".radio-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#radio_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');


        var formdata ='offset='+offset+'&limit='+limit;
            formdata += '&action=child_miraculous_favorites_radios_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {

                    $("#radio-content").html(result.radio);
                    $('.paging').find('.radio-pagination').removeClass("current");
                    $('#radio_pagin_'+ pagin).addClass( 'current' );

                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    $("#song-content").on("click",".delete_favourite_music", function(){
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
                    $(".fav_music_"+sid).hide();
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    
    $("#artist-content").on("click",".delete_favourite_artist", function(){
        var aid = $(this).attr('artistid');
        var formdata ='artistid='+aid;
            formdata += '&action=child_miraculous_remove_from_favourites_artist_list';
            //alert(aid);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    $(".artist-"+aid).hide();
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    $("#albums-content").on("click",".delete_favourite_albums", function(){
        var aid = $(this).attr('albumsid');

        var formdata ='albumsid='+aid;
            formdata += '&action=child_miraculous_remove_from_favourites_albums_list';
            
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    $(".albums-"+aid).hide();
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    $("#radio-content").on("click",".delete_favourite_radio", function(){
        var rid = $(this).attr('musicid');
        
        var formdata ='radioid='+rid;
            formdata += '&action=miraculous_remove_from_favourites_radio_list';
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: frontadminajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    $(".fav_music_"+sid).hide();
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    $(".current_tb").on('click', function(){
        var tab = $(this).text();
        if(tab == 'albums'){
            $("#act_tab").val('al');
        }else if(tab == 'tracks'){
            $("#act_tab").val('m');
        }else{
            $("#act_tab").val('ar');
        }
    });


    $(".show-arists").on('click', function(){
        var id = $(this).attr('id');
        var search_data = $('#'+id+' a').attr('data-search');

        var formdata ='search_data='+search_data;
            formdata += '&action=child_miraculous_artist_begins_with_a_specific_letter';
            
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $(".search_result").html(response);
                $(".paging-holder").hide();
                $('.alphabet-list').find('.link-arists').removeClass("active");
                $('#'+ id).addClass( 'active' );
            }
        });
    });
    
    /* for spotlights*/ 
    $(".spotlight_link").on('click', function(){
        var id = $(this).attr('id');
        var spotlight = $('#'+id+' a').attr('data-spotlight');
        
        var formdata ='spotlight_type='+spotlight;
            formdata += '&action=child_miraculous_spotlight_as_per_category';
            
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#tab_result").html(response);
                $('.spotlight-list').find('.spotlight_link').removeClass("active");
                $('#'+ id).addClass( 'active' );
            }
        });
    });

    $('#tab_result').on('click', '.ajax-page-paging a', function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        $(".ms_ajax_loader").show();
        $('#tab_result').fadeOut(100, function(){
            $(this).load(link + ' #tab_result', function() {
                $(this).fadeIn(100);
                $(".ms_ajax_loader").hide();
            });
        });
    });    
 
    // Artist Albums pagination 
    $(".ar-albums-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#ar_albums_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');
        var post_id = $(this).attr('data-postid');

        var formdata ='offset='+offset+'&limit='+limit+'&post_id='+post_id;
            formdata += '&action=child_miraculous_artist_albums_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#ar_albums-content").html(response);
                initAccordion();
                $('.paging').find('.ar-albums-pagination').removeClass("current");
                
                $('#ar_album_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });
    // Artist gallery pagination 
    $(".gallery-pagination").on('click', function(){
        
        var pagin = $(this).attr('data-pagin');
        var limit = $('#gallery_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');
        var post_id = $(this).attr('data-postid');
        var role = $(this).attr('data-role');

        var formdata ='offset='+offset+'&limit='+limit+'&post_id='+post_id+'&role='+role;
            formdata += '&action=child_miraculous_artist_gallry_pagination';
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#gallry-content").html(response);
                initAccordion();
                $('.paging').find('.gallery-pagination').removeClass("current");
                
                $('#gallry_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });

    // star rating
    $(".star-rating").on("click",".give-rating", function(){
        var data_star = $(this).attr('data-star');
        var post_id = $(this).attr('data-postid');

        var formdata ='post_id='+post_id+'&data_star='+data_star;
            formdata += '&action=child_miraculous_give_star_rating';
            
        //$(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                //$(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    toastr.success(result.msg);
                    location.reload();
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });


    // Fielter News by News Type Artist News 
    $(".newstype").on('click', function(){
        
        var newstype = $(this).attr('id');
        var artist_id = $(this).attr('data-artistid');

        var formdata ='newstype='+newstype+'&artist_id='+artist_id;
            formdata += '&action=child_miraculous_artist_news_by_news_type';
            
        
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $(".news-paging").hide();
                $("#tab_result").html(response);
                more_less_for_ajax();
                $('.news-type-list').find('li').removeClass("active");
                $('#'+ newstype).addClass( 'active' );
                
            }
        });
    });



    // News pagination 
    $(".newspagination").on('click', function(){
        
        var all_news = $('#all_news').val();
        var page = $('#all_news').attr('data-page');
        var pagin = $(this).attr('data-pagin');
        var limit = $('#news_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');
        var post_id = $(this).attr('data-postid');

        var formdata ='offset='+offset+'&limit='+limit+'&all_news='+all_news+'&page='+page;
            formdata += '&action=child_miraculous_news_pagination';
        //alert(formdata);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#tab_result").html(response);
                more_less_for_ajax();
                $('.paging').find('.newspagination').removeClass("current");
                
                $('#news_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });

    // Artist Event pagination 
    $(".eventpagination").on('click', function(){
        
        var all_events = $('#all_events').val();
        var pagin = $(this).attr('data-pagin');
        var limit = $('#event_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');
        var post_id = $(this).attr('data-postid');

        var formdata ='offset='+offset+'&limit='+limit+'&all_events='+all_events;
            formdata += '&action=child_miraculous_artist_events_pagination';
        //alert(formdata);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#tab_result").html(response);
                more_less_for_ajax();
                $('.paging').find('.eventpagination').removeClass("current");
                
                $('#event_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });

    var showChar = 500;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "More";
    var lesstext = "Less";
    
    more_less_for_ajax();
    
    function more_less_for_ajax(){
        $('.more').each(function() {
            var content = $(this).html();
     
            if(content.length > showChar) {
     
                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);
     
                var html = c + '<span class="moreellipses">' + ellipsestext+
                '&nbsp;</span><span class="morecontent"><span>' + h +
                '</span>&nbsp;&nbsp;<a href="javascript:;" class="morelink">' + moretext +
                '</a></span>';
     
                $(this).html(html);
            }
     
        });

        $(".morelink").click(function(){
            if($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    }

/* for radio genre filter **/
    $(".radio_link").on('click', function(){
        var id = $(this).attr('id');
        var radio_genre = $('#'+id+' a').attr('data-radio');
        
        var formdata ='genre='+radio_genre;
            formdata += '&action=child_miraculous_radio_as_per_genre';
            
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $("#tab_result").html(response);
                $('.spotlight-list').find('.radio_link').removeClass("active");
                $('#'+ id).addClass( 'active' );
            }
        });
    });

// Radio genre pahination
 
    $('.radio-section').on('click', '.radio_genre_pagin', function(e){
        
        var all_radio = $('.radio-section #all_radio').val();
        var pagin = $(this).attr('data-pagin');
        var limit = $('.radio-section #radio_offset').attr('data-limit');
        var offset = $(this).attr('data-offset');
        var post_id = $(this).attr('data-postid');

        var formdata ='offset='+offset+'&limit='+limit+'&all_radio='+all_radio;
            formdata += '&action=child_miraculous_radio_genre_pagination';
        //alert(formdata);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $(".ms_ajax_loader").hide();
                $(".radio-section #radio_pagin_result").html(response);
                $('.paging').find('.radio_genre_pagin').removeClass("current");
                
                $('#radio_pagin_'+ pagin).addClass( 'current' );
                
            }
        });
    });
    
    /* for radio genre filter **/
    $(".btn-move").on('click', function(){
        setTimeout(function(){ 
           var href = $('.selected-slide .play_radio').attr('data-href');
           var name = $('.selected-slide .name').text();
            $('.selected-slide .play_radio').addClass('play_music');
            $('.selected-slide .name .radio_url').attr('href',href);
            $('.radio_artist_name span').html('“ '+name+' ”');
            $('.selected-slide .play_btn').removeClass('hide');
        }, 1000);

    });

    $(".showCgmTv").on('click', function(){
        var videoid = $(this).attr('data-url');
        $(".ms_ajax_loader").show();
        $('#video-link').html('<iframe width="640" height="360" src="https://www.youtube.com/embed/'+videoid+'?rel=0;&autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen include></iframe>');
        $(".ms_ajax_loader").hide();
        
        
    });

    /* add friend */
    $("#add-remove-friend").on("click", function(){
        var fid = $(this).attr('data-fid');
        var type = $(this).attr('data-type');
        var status = $(this).attr('data-status');

        var formdata ='fid='+fid+'&type='+type;
            formdata += '&action=child_miraculous_add_friend';
            //alert(formdata);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    if(type == 'add'){
                     $("#add-remove-friend").text('Request Sent');    
                     $("#add-remove-friend").removeClass('add-icon');    
                     $("#add-remove-friend").addClass('remove-icon');    
                     $("#add-remove-friend").attr('data-type','remove');    
                    }else{
                        $("#add-remove-friend").text('Add Friend');
                        $("#add-remove-friend").removeClass('remove-icon');    
                        $("#add-remove-friend").addClass('add-icon');
                        $("#add-remove-friend").attr('data-type','add'); 
                    }
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    /* remove friend */
    $(".add-remove-friend").on("click", function(){
        var fid = $(this).attr('data-fid');
        var type = $(this).attr('data-type');
        var status = $(this).attr('data-status');
        var page = $(this).attr('data-page');

        var formdata ='fid='+fid+'&type='+type;
            formdata += '&action=child_miraculous_add_friend';
            //alert(formdata);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    if(page == 'list'){
                         $("#list_"+fid).hide();
                    }
                    if(type == 'add'){
                     $(".add-remove-friend").text('Request Sent');    
                     $(".add-remove-friend").removeClass('add-icon');    
                     $(".add-remove-friend").addClass('remove-icon');    
                     $(".add-remove-friend").attr('data-type','remove');    
                    }else{
                        $(".add-remove-friend").text('Add Friend');
                        $(".add-remove-friend").removeClass('remove-icon');    
                        $(".add-remove-friend").addClass('add-icon');
                        $(".add-remove-friend").attr('data-type','add'); 
                    }
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });
    
    /* Send Message */
    $(".send-message").on("click", function(){
        var receiver = $(this).attr('data-receiver');
        $('#message-popup').modal('show');
        $('#receiver').val(receiver);
    });

    /* for message form  */
    $("#message-form").on('submit', function(e){
        e.preventDefault();

        var receiver = $("#receiver").val();
        var subject = $("#subject").val();
        var message = $("#message").val();
        var message_file = $("#message-file").val();
        var file = '';

        var subjectvalid = true;
        var messagevalid = true;
        var message_file_valid = true;


        if( subject == '' ) {
            $(".subject-error").text("Subject can't empty.");
            subjectvalid = false;
        }else{
            $(".subject-error").text("");
            subjectvalid = true;
        }
        if( message == '' ) {
            $(".message-error").text("Message can't empty.");
            messagevalid = false;
        }else{
            $(".message-error").text("");
            messagevalid = true;
        }
        if(message_file!=''){
            file = $('#message-file')[0].files[0];
            var file_size = file.size;
            if(file_size > 2000000) {
               $(".file-size-error").text("Please upload file less than 2MB.");
               message_file_valid = false;
             }else{
                $(".file-size-error").text("");
                message_file_valid = true;
             }
        }
        
         if(subjectvalid == true && messagevalid == true && message_file_valid == true) {


            var fd = new FormData();
            var file = jQuery(document).find('input[name=message-file]');
            fd.append("file", file[0].files[0]);
            fd.append('action', 'miraculous_child_send_message');
            fd.append('receiver', receiver );
            fd.append('subject', subject );
            fd.append('user_message', message );

               
                
            $("#submit-message").hide();
            $(".hst_loader").show();
           
            $.ajax({
                type: 'post',
                url: front_ajax.ajax_url,
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    var result = JSON.parse(response);
                    if( result.status == 'success' ) {
                        toastr.success(result.msg);
                        $("#message-form")[0].reset();
                    }else{
                        $.each(result, function(i,n){
                            if(n != 'false'){
                                toastr.error(n);   
                            }
                        });
                    }

                    $(".hst_loader").hide();
                    $("#submit-message").show();

                }
            });
        }
    });

    /* pay with wallet */
    $("#tab-wallet").on("click",'.wallet-pay', function(){
        var pid = $(this).attr('data-pid');
        var formdata ='pid='+pid;
            formdata += '&action=child_miraculous_get_subscription_by_wallet';
            //alert(formdata);
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'success' ) {
                    toastr.success(result.msg);
                    $('#back_page').click();
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });
    
    /* albums upload form for artist */
    $("#upload_artist_albums_form").on('submit', function(e){
        e.preventDefault();
        var album_name = $("#album_name").val();
        var album_price = $("#album_price").val();
        var album_image_id = $("#album_image_id").val();
        var description = $("#description").val();
       

        var song_title    = $("input[name='song_title[]']").map(function(){return $(this).val();}).get();
        var song_image_id = $("input[name='song_image_id[]']").map(function(){return $(this).val();}).get();
        var song_file_id  = $("input[name='song_file_id[]']").map(function(){return $(this).val();}).get();
        var file_url      = $("input[name='file_url[]']").map(function(){return $(this).val();}).get();
        

        $("input[type='text'][name='song_title[]']").each(function() {
            var selectedTr = $(this);
           
            var value = $(this).val();
            if (!value) {
                toastr.error('Please enter song name name.');
                return;
            } 
        });

        $("input[type='hidden'][name='song_file_id[]']").each(function() {
            var selectedTr = $(this);
           
            var value = $(this).val();
            if (!value) {
                toastr.error('Please select music file.');
                return;
            } 
        });


        if(album_name == '' ){
            toastr.error('Please enter album name.');
            return;
        }
        //  if(album_price == '' ){
        //     toastr.error('Please enter album price.');
        //     return;
        // }
        var album_genres = [];
        $('input.album_genres:checkbox:checked').each(function () {
            album_genres.push($(this).val());
        });

        var full_file_data = [];
        $("input[type='hidden'][name='full_file_data[]']").each(function() {
            full_file_data.push($(this).val());
        });

        
        var formdata ='album_name='+album_name+'&album_price='+album_price+'&album_image_id='+album_image_id+'&description='+description;
            formdata +='&album_genres='+album_genres+'&song_title='+song_title+'&song_image_id='+song_image_id+'&song_file_id='+song_file_id;
            formdata +='&file_url='+file_url+'&full_file_data='+full_file_data;
            formdata += '&action=child_miraculous_artist_album_upload';

        $(".hst_loader").show();
        $("#upload_submit").hide();
        $.ajax({
            type: 'post',
            url: frontadminajax.ajax_url,
            data: formdata,
            
            success: function(response){
                var result = JSON.parse(response);
                if(result.status == 'true'){
                    
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

    $(".albums-list").on("click",".delete_artists_albums", function(){
        var aid = $(this).attr('albumsid');

        var formdata ='albumsid='+aid;
            formdata += '&action=child_miraculous_remove_from_artist_albums_list';
            
        $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $(".ms_ajax_loader").hide();
                if( result.status == 'true' ) {
                    $(".albumsid-"+aid).hide();
                    toastr.success(result.msg);
                }else{
                    toastr.error(result.msg);
                }
            }
        });
    });

    // albums popup
    $(".album-gallery").on("click",".add_to_popup", function(){
        var aid = $(this).attr('data-albumid');

        var formdata ='albumsid='+aid;
            formdata += '&action=child_miraculous_albums_popup_list';
            
        
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
              $('#albums-popup').modal('show');
              $('#albums-popup-content').html(response);
              initHideTableRows();
            }
        });
    });


  $('.check-password').keyup(function() {
    $('#result').html(checkStrength($('.check-password').val()))
   })
   
   function checkStrength(password) { 
       //initial strength 
       var strength = 0 
       var password = $.trim(password);

       //if the password length is less than 6, return message. 
       if (password.length < 6) { 
            $('#result').removeClass();
            $('#result').addClass('short');
            $('.password-validate').prop('disabled', true);
            $('.password-validate').css('background', '#dddddd');
            return 'Too short.';
        } 


        //length is ok, lets continue. //if length is 8 characters or more, increase strength value 
        if (password.length > 7) strength += 1 
        //if password contains both lower and uppercase characters, increase strength value 
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1 
        //if it has numbers and characters, increase strength value 
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1 
        //if it has one special character, increase strength value 
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1 
        //if it has two special characters, increase strength value 
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) strength += 1 
        //now we have calculated strength value, we can return messages //if value is less than 2 
        if (strength < 2 ) { 
            $('#result').removeClass();
            $('#result').addClass('weak');
           $('.password-validate').prop('disabled', true);
            $('.password-validate').css('background', '#dddddd');
            return 'Weak' 
        } else if (strength == 2 ) { 
            $('#result').removeClass();
            $('#result').addClass('good');
            $('.password-validate').prop('disabled', false);
            $('.password-validate').css('background', '#ffba00');
            return 'Good';
        } else { 
            $('#result').removeClass();
             $('#result').addClass('strong');

             $('.password-validate').prop('disabled', false);
             $('.password-validate').css('background', '#ffba00');
              return 'Strong';
              
        } 
    } 

    //alert("Music");
    get_user_unread_message();

})(jQuery);

function get_user_message(sender_id,receiver_id,id){

        $('.messages-sort-list').find('.user-threads').removeClass("active");
        $('#'+id).addClass("active");
        $("#message-loding").html('');
        var formdata ='sender_id='+sender_id+'&receiver_id='+receiver_id;
         formdata += '&action=child_miraculous_get_user_conversation';
        $(".msg_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $("#get-message").html(response);
                $(".msg_ajax_loader").hide();
            }
        });
}

function showRplyForm(mid){

        var formdata ='mid='+mid;
         formdata += '&action=child_miraculous_get_user_reply_form';
        $(".reply_section .reply_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $("#show_reply_form_"+mid).html(response);
                $(".reply_section .reply_loader").hide();
            }
        });
}

function sendReplyMessage(mid){

        var message = $("#message").val();
        if(message==''){
            $(".message_error").text("Message can't be empty!");
            return false;
        }

        var formdata ='mid='+mid+'&message='+message;
         formdata += '&action=child_miraculous_save_user_reply_conversation';
        $(".show_reply_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                $("#reply-messages-section").html(response);
                $("#message").val('');
                $(".show_reply_loader").hide();
            }
        });
}

function deleteMessage(mid,removesectionID=''){

        var formdata ='mid='+mid;
         formdata += '&action=child_miraculous_delete_user_conversation';
        $(".reply_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){

                var result = JSON.parse(response);
                if( result.status == 'success' ) {
                    toastr.success(result.msg);
                    if(removesectionID!=''){
                        $("#"+removesectionID).hide();
                    }
                    
                }else{
                    $.each(result, function(i,n){
                        if(n != 'false'){
                            toastr.error(n);   
                        }
                    });
                }
                
                $(".reply_loader").hide();
            }
        });
}

function readMessage(mid){
        $("#message-content-"+mid).removeClass('active-item');
        var formdata ='mid='+mid;
         formdata += '&action=child_miraculous_read_user_conversation';
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                if( result.status == 'success' ) {
                    //toastr.success(result.msg);
                }else{
                    $.each(result, function(i,n){
                        if(n != 'false'){
                            //toastr.error(n);   
                        }
                    });
                }
                
            }
        });
}


function cancelRplyForm(mid){
    var link = '<a href="javascript:;" class="button" onclick="showRplyForm('+mid+')">Reply</a>';
    $("#show_reply_form_"+mid).html(link);
}

function checkUserWalletFunds(pid){
    $('.packages-items').removeClass('package-active');
    $('#package-'+pid).addClass('package-active');
        var formdata ='pid='+pid;
         formdata += '&action=child_miraculous_check_user_wallet_funds';
         $(".ms_ajax_loader").show();
        $.ajax({
            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                var result = JSON.parse(response);
                $('#tab-paypal').html(result.paypalData);
                $('.wallet-form').html(result.walletData);
                $(".ms_ajax_loader").hide();
            }
        });
}

/*04-06-2019*/


function get_user_unread_message(){
       
        var formdata ='action=unreadMessage';
        $.ajax({

            type: 'post',
            url: front_ajax.ajax_url,
            data: formdata,
            success: function(response){
                
                var result = JSON.parse(response);
                //alert(result.count);
                
                if(result.status == 'success'){
                    
                  $('.message-count').append('<span class="msg_count_unread">'+result.count+'</span>');
                
                }
            }

        });
}


/*04-06-2019*/






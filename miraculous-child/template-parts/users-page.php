<?php
   /**
    * Template Name: Users Page
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   
   
   
   $miraculous_page_data = '';
   if (function_exists('fw_get_db_post_option')):  
    $miraculous_page_data = fw_get_db_post_option(); 
   
   endif;
   
   
   get_header();
                    
   global $woocommerce;
    $countries_obj   = new WC_Countries();
    $countries   = $countries_obj->__get('countries');
    
    $genres = get_categories('taxonomy=genre&type=ms-artists');

    $user_id = get_current_user_id();

    $exclude = array();
    if($user_id!=''){
      $exclude = array($user_id);
    }


?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <div class="content-block search-criteria">
               <form action="" class="advanced-search" method="get">
                  <fieldset>
                     <div class="form-row">
                        <div class="field-item">
                           <label for="input-country">User Genre</label>
                           <select name="user_genre" id="input-genre">
                            <option value="">Select Genre</option>
                           <?php
                              if(!empty($genres)){
                                 foreach ($genres as $genres_key => $genre) {
                              ?>
                                <option value="<?php echo $genre->slug;?>" <?php if(isset($_GET['user_genre']) && $_GET['user_genre']==$genre->slug){echo 'selected';}?>><?php echo $genre->name; ?></option> 
                              <?php
                                   
                                 }
                              }
                           ?>
                           </select>
                        </div>
                        <div class="field-item">
                           <label for="input-country">Country</label>
                           <select name="user_country" id="input-country">
                            <option value="">Select country</option>
                           <?php
                              if(!empty($countries)){
                                 foreach ($countries as $country_key => $country) {
                                    ?>
                                <option value="<?php echo $country_key;?>" <?php if(isset($_GET['user_country']) && $_GET['user_country']==$country_key){echo 'selected';}?>> <?php echo $country; ?></option> 
                              <?php
                                   
                                 }
                              }
                           ?>
                           </select>
                        </div>
                        <div class="field-item btn-row">
                        	<button type="submit" class="button">Search</button>
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
            <section class="result-gallery">
               <div class="section-header">
               <?php 

	              if(isset($_GET['user_genre']) && $_GET['user_genre'] !='' || isset($_GET['user_country']) && $_GET['user_country'] !=''){
	                    echo '<h1>Search Results </h1>'; 
	              }

               ?>
                  <!-- <h1>Search Results</h1> -->
               </div>
               <div class="result-list">
               <?php

                  // how many users to show per page
                  $users_per_page = 3;

                  $current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
                  $meta_query = array();

                  if(isset($_GET['user_genre']) && $_GET['user_genre'] !=''){
                     $genres = sprintf(':"%s";', $_GET['user_genre']);
                     $meta_query[] = array( 'key' => 'user_genres', 'value' => $genres, 'compare' => 'LIKE' );
                  }
                  if(isset($_GET['user_country']) && $_GET['user_country'] !=''){
                     $meta_query[] = array( 'key' => 'billing_country', 'value' => $_GET['user_country'], 'compare' => '=' );
                  }

                  
                  // main user query
                  $args  = array(
                      'role'      => 'Subscriber',
                      'orderby'   => 'display_name',
                      'fields'    => 'all_with_meta',
                      'exclude' => $exclude,
                      'meta_query' => $meta_query,
                      'paged' => $current_page,
					            'number' => $users_per_page  
                  );

                  
                  
                  // Create the WP_User_Query object
                  $wp_user_query = new WP_User_Query($args);
                  $total_users = $wp_user_query->get_total();
				          $num_pages = ceil($total_users / $users_per_page);



                  // Get the results
                  $authors = $wp_user_query->get_results();
                  // check to see if we have users
                  if (!empty($authors)) {
                     foreach ($authors as $key_user => $author){
                       
                        //if(get_current_user_id() != $author->ID){

                        
                        $register_date = $author->user_registered;

                        $last_active = get_user_meta($author->ID,'wc_last_active',true);
                        
                        $user_profile_img = get_user_meta($author->ID, 'user_profile_img', true);
                        //die();
                        $user_avatar = get_avatar_url( $author->ID );

                        if($user_profile_img!=''){
                           $profile_img = $user_profile_img;
                        }else{
                           $profile_img = $user_avatar;
                        }

                        
                        
                        
               ?>
                  <article class="result-item">
                     <div class="item-holder">
                        <img src="<?php echo $profile_img;?>" alt="photo" width="58" height="58">
                        <div class="text-holder">
                           <h3><?php echo $author->first_name .' '.$author->last_name; ?></h3>

                           <dl>
                              <dt>Lat online:</dt>
                              <dd><?php echo ($last_active!='') ? date("d.m.Y",$last_active): 'Not Active';?></dd>
                              <dt>register:</dt>
                              <dd><?php echo ($register_date!='') ? date_format(date_create($register_date),"d.m.Y"):'';?></dd>
                           </dl>
                           <a href="<?php echo esc_url(home_url( '/users-profile')); ?>/<?php echo $author->user_login;?>" class="button">VIEW</a>
                        </div>
                     </div>
                  </article>
               <?php 
                     //}else{echo 'current';}
                  }
      
                  }else{
                      echo '<div class="no-found-data">No Users found</div>';
                  }
               ?>
               </div>
            </section>
			<?php

			$links = paginate_links( array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => 'page/%#%/',
				'prev_text' => __('&laquo; Prev'), // text for previous page
				'next_text' => __('Next &raquo;'), // text for next page
				'current' => max( 1, get_query_var('paged') ),
				'total' => $num_pages,
				'type' => 'array'
				) );
			if(!empty($links)):
			?>
            <div class="content-block paging-box">
            <?php
            	if( is_array( $links ) ) {
		        	echo '<ul class="paging">';
			        foreach ( $links as $link ) {
			                echo "<li>$link</li>";
			        }
		       		echo '</ul>';
		        }
            ?>
            </div>
           <?php endif;?>
         </div>

         
         <?php 
            // Include the featured songs content template.
            get_template_part( 'template-parts/content', 'left-side-bar' );
         ?>
         
      </div>
   </div>
</main>
<?php get_footer();?>

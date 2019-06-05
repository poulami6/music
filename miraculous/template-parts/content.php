<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miraculous
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php 
    $miraculous_page_data = '';
    if(function_exists('fw_get_db_post_option')): 
        $miraculous_page_data = fw_get_db_post_option();   
    endif; 
    $theme_sidebar = '';
    if(!empty($miraculous_page_data['page-sidebar'])):
        $theme_sidebar = $miraculous_page_data['page-sidebar'];
    else:
        $theme_sidebar = esc_html__('right','miraculous');
    endif;
    if($theme_sidebar == 'right' || $theme_sidebar == 'left' ):
         $thumb_w ='1200';
         $thumb_h = '700';
    else:
        $thumb_w ='800';
        $thumb_h = '500';
    endif;
    if(has_post_thumbnail(get_the_ID())):
        $ms_attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'full');
        $thum_image = miraculous_aq_resize($ms_attachment_url, $thumb_w, $thumb_h,false);
	endif;	
	if(!empty($thum_image)):
	?>
	 <a href="<?php echo esc_url(get_the_permalink(get_the_ID())); ?>">
	      <span class="ms_blog_date"><?php echo get_the_date(); ?></span>
   	   <img src="<?php echo esc_url($thum_image); ?>" alt="<?php the_title_attribute(); ?>" />
	  </a>
	<?php endif; ?>
    <header class="entry-header">
		<?php
		if('post' === get_post_type()) :
		?>
		<div class="entry-meta">
		<?php
		 miraculous_posted_on();
		 miraculous_posted_by();
		?>
		</div><!-- .entry-meta -->
		<?php
		endif;
		echo '<h3 class="entry-title">';
			if(is_sticky() && is_home() ) :
				echo '<div class="sticky-post">
				 <i class="fa fa-thumb-tack" aria-hidden="true"></i></div>';
			endif;
		echo '<a href="'.esc_url( get_permalink() ).'" rel="bookmark">'.
				get_the_title().'</a></h3>';
		?>
	</header><!-- .entry-header -->
    <div class="entry-content">
		<?php
		the_content(sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'miraculous' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'miraculous' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		$thum_image = $entryfooter = '';
		if(is_user_logged_in()):
		    $entryfooter = 'ms-entry-footer';
		else:
		    $entryfooter = '';
		endif;
		?>
	</div><!-- .entry-content --> 
    <footer class="entry-footer <?php echo esc_attr($entryfooter); ?>">
		<?php miraculous_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
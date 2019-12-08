<style>
    .thumbnail-container {
        text-align: center;
    }

    div.readmore {
        /* display:inline-block; */
        color: white;
        border: 1px solid #CCC;
        background: blue;
        box-shadow: 0 0 5px -1px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        vertical-align: middle;
        max-width: 80px;
        padding: 5px;
        text-align: center;
        margin: auto;
        font-size: 12px;
    }

    div.readmore:active {
        color: red;
        box-shadow: 0 0 5px -1px rgba(0, 0, 0, 0.6);
    }

    div.bio {
        display: none;
    }

    .wrapper {
        display:grid;
        grid-template-columns: 318px 318px 318px;
    }
    .team-member-item {
        float:left;
        position:relative;
        display:block;
    }
    .team-member-item div{
        text-align:center;
    }
    .team-member-item h2{
        text-align:center;
    }

</style>
<script type="text/javascript">
    function toggleRead(el) {
        //console.log(jQuery(el));
        if (jQuery(el).siblings("div.bio").is(":visible")) {
            //console.log(jQuery(el).siblings("div.bio"));
            jQuery(el).html("<?php _e( 'Read More' ); ?>");
            jQuery(el).siblings("div.bio").hide();
        } else {
            jQuery(el).html("<?php _e( 'Read Less' ); ?>");
            jQuery(el).siblings("div.bio").show();
        }
        //console.log(jQuery(el).parent().children("div.bio"));
    }
</script>
<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1><?php _e( 'Team Members' ); ?></h1>
            </header><!-- .page-header -->
            <?php
            $args      = array(
				'post_type'      => 'team_members',
				'posts_per_page' => TEAM_MEMBERS_PER_PAGE

			);
			$the_query = new WP_Query( $args );
			?>
			<?php if ( $the_query->have_posts() ) : ?>

                <!-- the loop -->
                <div class="wrapper">
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="team-member-item">
                            <div class="thumbnail-container">
								<?php
								the_post_thumbnail( array( TEAM_MEMBERS_THUMBNAIL_WIDTH, TEAM_MEMBERS_THUMBNAIL_HEIGHT ) );
								?>
                            </div>
                            <h2><?php the_title(); ?></h2>
                            <div><?php echo wp_kses(get_post_meta( $post->ID, 'position', true ), array('b')); ?></div>
                            <div>
								<?php
								$facebook_url = get_post_meta( $post->ID, 'facebook_url', true );
								if ( ! empty( $facebook_url ) ) {
									?>
                                    <a href="<?php echo wp_kses($facebook_url,array()); ?>">
                                        <img title="Facebook" alt="Facebook"
                                             src="https://socialmediawidgets.files.wordpress.com/2014/03/02_facebook1.png"
                                             width="35" height="35"/>
                                    </a>
									<?php
								}
								?>
								<?php
								$twitter_url = get_post_meta( $post->ID, 'twitter_url', true );
								if ( ! empty( $twitter_url ) ) {
									?>
                                    <a href="<?php echo wp_kses($twitter_url,array()); ?>">
                                        <img title="Twitter" alt="Twitter"
                                             src="https://socialmediawidgets.files.wordpress.com/2014/03/01_twitter1.png"
                                             width="35" height="35"/>
                                    </a>
									<?php
								}
								?>
                            </div>
                            <div class="bio">
								<?php
								the_content();
								?>
                            </div>
                            <div class="readmore" onClick="toggleRead(this);"><?php _e( 'Read More' ); ?></div>

                        </div>
					<?php endwhile; ?>
                    <!-- end of the loop -->
                </div>
                <!-- pagination here -->

				<?php wp_reset_postdata(); ?>

			<?php else : ?>
                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>
		<?php


		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>

    <div class="page">
    <div class="page-content">
        <div class="content-block mt-0 bg-white block-shadow">
            <div class="content-block-inner">

                <div class="image-single-post">
                    <div></div>
					<?php if ( get_the_post_thumbnail() ) { ?>
						<?php the_post_thumbnail( 'full' ); ?>
					<?php } ?>
                </div>

               

				<?php

				while ( have_posts() ) : the_post();

					?>
                    <div class="entry-content">
					 <header>
						<?php
						the_title( sprintf( '<h1>', esc_url( get_permalink() ) ), '</h1>' );
						?>
						<span class="entry-date pull-right">
						<span class="post_my"><?php the_time( 'Y' ); ?></span>
						<span class="post_day custom-font"><?php the_time( 'F d' ); ?></span>

					</header><!-- .entry-header -->
						<?php
						the_content();
						?>

                    </div><!-- .entry-content -->
                    <?php
                    // GET TAGS BY POST_ID
                    $tags = get_the_tags( $post->ID );
                    if ( ! empty( $tags ) ) {
                        echo '<div class="single-page-tags"><h5>برچسب ها : </h5>';
                        foreach ( $tags as $tag ) : ?>

                            <a class="btn btn-warning"
                               href="<?php bloginfo( 'url' ); ?>/tag/<?php print_r( $tag->slug ); ?>">
                                <?php print_r( $tag->name ); ?>
                            </a>,

                        <?php endforeach;
                        echo '</div>';
                    }
                    ?>

				<?php

				endwhile;
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

            </div>
        </div>

    </div>

<?php
get_footer();

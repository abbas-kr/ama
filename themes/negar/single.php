<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>

    <div class="page">
    <div class="page-content">
        <div class="content-block mt-0 bg-white block-shadow">
            <div class="content-block-inner">

                <header>
                    <span class="entry-date pull-right">
						<span class="post_my"><?php the_time( 'Y' ); ?></span>
						<span class="post_day custom-font"><?php the_time( 'd' ); ?></span>
						<span class="post_year custom-font"><?php the_time( 'F' ); ?></span>
                    </span>
                    <?php
                    the_title( sprintf( '<h1>', esc_url( get_permalink() ) ), '</h1>' );
                    ?>
                    <a href="<?= get_home_url() ?>"><i class="far fa-chevron-left"></i></a>


                </header><!-- .entry-header -->

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

                        <div class="icons-buttons-down">
                            <a href="<?php echo get_comments_link($post->ID); ?>"><?php echo $post->comment_count; ?> <i class="fal fa-comment-alt"></i></a>
                            <?= gt_get_post_view(); ?>
                            <i class="fal fa-share-alt"></i>
                        </div>

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

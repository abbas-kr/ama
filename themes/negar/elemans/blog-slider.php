<?php if ( ! defined( 'ABSPATH' ) ) exit; /* negar */ ?>
<?php
$defaults = array(
    'numberposts' => 10,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
);
$list = get_posts($defaults);

if (!empty($list)) { ?>
<section>
    <header class="ngr-eleman-title"><span>مقالات</span>وب سایت
	<a class="list-link" href="<?= get_permalink(get_option('page_for_posts')) ?>">
            <i class="fal fa-ellipsis-h"></i>
        </a>
	</header>
    <div class="blog-swiper-container">
        <div class="hscroll-product-slider swiper-wrapper">
            <?php foreach ($list as $key => $post) { ?>
                <div class="swiper-slide">
                    <div class="entry-meta">
                        <span class="latest_post_date">
                            <span class="post_year"><?php echo get_the_time('Y', $post->ID); ?></span>
                            <span class="post_day"><?php echo get_the_time('d', $post->ID); ?></span>
                            <span class="post_month"><?php echo get_the_time('F', $post->ID); ?></span>
                        </span>
                        <div class="widget-title">
                            <h4><a href="<?php echo get_permalink($post->ID) ?>"><?php echo $post->post_title; ?></a>
                            </h4>
                        </div>
                    </div>


                    <div class="img_over">
                        <a href="<?php echo get_permalink($post->ID) ?>">
                            <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
                        </a>
                    </div>

                    <?php $comment_count = $post->comment_count; ?>

                    <div class="readmore">
                        <a href="<?php echo get_permalink($post->ID) ?>"><?php esc_html_e('ادامه مطلب', 'zanbil'); ?><i class="fal fa-ellipsis-h"></i></a>
                    </div>

                    <div class="entry-comment">
                        <a href="<?php echo get_comments_link($post->ID); ?>"><?php echo $post->comment_count; ?> <i class="fal fa-comment-alt"></i></a>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>



<?php if (!defined('ABSPATH')) exit;
get_header();
function get_last_post_image($cat_slug){
    $args = array(
        'category_name' => $cat_slug, // it should be slug of category, not name.
        'posts_per_page' => 1,
        'order_by' => 'date',
        'order' => 'desc'
    );
    $post = get_posts( $args );
    if($post) {
        $post_id = $post[0]->ID;
        if(has_post_thumbnail($post_id)){
            echo get_the_post_thumbnail($post_id, 'thumbnail');
        }
    }
}
if (have_posts()) : ?>
    <div class="page">
        <div class="page-content">
            <!-- Tab links -->
            <div class="tabpost">
                <button class="tablinks" onclick="ngrtab(event, 'tpost')" id="qwer">نوشته ها</button>
                <button class="tablinks" onclick="ngrtab(event, 'tcat')"> دسته بندی</button>
            </div>
            <!-- Tab content -->
            <div id="tcat" class="tabcontent">
				<?php
				$categories = get_categories( $args );
				echo'<ul id="primary-navigation" class="primary-navigation-blog" role="navigation">';
				foreach ( $categories as $category ) {
					echo '<div class="title-intro content-block-title">';
					echo get_last_post_image($category->slug);
					echo '<a href="' . get_category_link( $category->term_id ) . '">' .  $category->name . '</a><span>'.$category->category_count.'پست</span></div>';

				}
				echo'</ul>';
				?>
            </div>
            <!-- Tab content -->
            <div id="tpost" class="tabcontent">
				<?php while (have_posts()) : the_post(); ?>
                    <div class="archiv-blog">
                        <div class="entry-meta">
                        <span class="latest_post_date">
                            <span class="post_year"><?php echo get_the_time('Y', $post->ID); ?></span>
                            <span class="post_day"><?php echo get_the_time('d', $post->ID); ?></span>
                            <span class="post_month"><?php echo get_the_time('F', $post->ID); ?></span>
                        </span>
                            <div class="widget-title">
                                <h4>
                                    <a href="<?php echo get_permalink($post->ID) ?>"><?php echo $post->post_title; ?></a>
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
                            <a href="<?php echo get_permalink($post->ID) ?>"><?php esc_html_e('ادامه مطلب', 'zanbil'); ?>
                                <i class="fal fa-ellipsis-h"></i></a>
                        </div>

                        <div class="entry-comment">
                            <a href="<?php echo get_comments_link($post->ID); ?>"><?php echo $post->comment_count; ?> <i
                                        class="fal fa-comment-alt"></i></a>
                        </div>
                    </div>

				<?php

				endwhile;

				the_posts_pagination();

				?>
            </div>
        </div>
    </div>
    <script>
        function ngrtab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("qwer").click();
    </script>

<?php endif;


get_footer();

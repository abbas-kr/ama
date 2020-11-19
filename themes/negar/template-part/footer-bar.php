<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$avn_option = getSetting();
?>

<div id="category-modal" class="<?= $avn_option['category_selection'] ?>"><div id="ngr-preloader"></div></div>

<?php
if ( ( is_product_category() || is_shop() ) && is_active_sidebar( 'ngr_filter' ) ) {
	echo '<a class="ngr-filter-product-button" href="javascript:void(0)"><i class="fal fa-sliders-h"></i></a>';
}
?>

<!-- Footer Nav-->
<div class="footer-nav-area">
    <div class="negar-footer-nav">
		<?php if ( is_product() ) { ?>
            <ul class="buttonbar-second">
				<?php
				require NGR_PATH . '/template-part/toolbar-icon/cart.php';
				require NGR_PATH . '/template-part/toolbar-icon/category.php';
				require NGR_PATH . '/template-part/toolbar-icon/homepage.php';
				?>
            </ul>
		<?php } elseif ( is_cart() || is_checkout() ) { ?>

            <ul class="buttonbar-second">
				<?php
				require NGR_PATH . '/template-part/toolbar-icon/account.php';
				require NGR_PATH . '/template-part/toolbar-icon/category.php';
				require NGR_PATH . '/template-part/toolbar-icon/homepage.php';
				?>
            </ul>

		<?php } else { ?>
            <ul class="buttonbar-first">
				<?php
				$i = 0;
				foreach ( $avn_option['bottom_toolbar_button']['enable'] as $key => $value ) {
				    if ($key=='placebo'){ continue; }
					if ( file_exists( NGR_PATH . '/template-part/toolbar-icon/' . $key . '.php' ) ) {
						require NGR_PATH . '/template-part/toolbar-icon/' . $key . '.php';
					}
					$i ++;
					if ( $i == 3 ) {
						echo '</ul><ul class="buttonbar-second">';
					}
				}
				?>
            </ul>
		<?php } ?>
    </div>
</div>

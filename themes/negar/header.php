<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
	<?php wp_head(); ?>

</head>

<body <?php body_class( 'theme-light' ); ?>>


<?php get_template_part( 'template-part/top-header' ); ?>

<?php if ( is_cart() || is_checkout() ) {
	get_template_part( 'template-part/checkout-sub-header' );
}
?>

<?php get_template_part( 'template-part/main-sidebar' ); ?>

<div class="page-content-wrapper">

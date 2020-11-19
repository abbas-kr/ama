<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $avn_negar;
?>

<!-- Sidenav Black Overlay-->
<div class="sidenav-black-overlay"></div>
<!-- Side Nav Wrapper-->
<div class="suha-sidenav-wrapper" id="sidenavWrapper">
    <!-- Sidenav Logo-->
    <div>
		<?php
		if ( ! empty( $avn_negar['site_logo']['url'] ) ) {
			if ( $avn_negar['logo_position'] == "sidebar" ) { ?>
                <a href="<?= get_site_url() ?>"><img src="<?= $avn_negar['site_logo']['url'] ?>"
                                                     alt="<?= get_bloginfo() ?>"></a>
			<?php }
		}
		if ( ! empty( $avn_negar['site_name'] ) ) {
			if ( $avn_negar['logo_position'] == "center" ) { ?>
                <a href="<?= get_site_url() ?>">
                    <?php
                    if (is_front_page()) {
                        echo '<h1>' . $avn_negar['site_name'] . '</h1>';
                    }
                    else{
                        echo '<strong>' . $avn_negar['site_name'] . '</strong>';
                    }
                    ?>
                </a>
			<?php }
		} ?>

    </div>
    <!-- Sidenav Menu-->
	<?php

	if ( isset( $avn_negar['side_menu'] ) ) {
		wp_nav_menu( array( 'menu'         => $avn_negar['side_menu'],
		                    'container_id' => 'accordian',
		                    'after'        => '<i class="fal fa-minus"></i>'
		) );
	}

	?>
    <!-- Sidenav Button-->
    <div class="bottom-part">
		<div class= "page-widget">
			<?php
			if ( ! empty( $avn_negar['menu_page'] ) ) {
				echo '<a class="sidebar-menupage" href="' . get_permalink( $avn_negar['menu_page'] ) . '">' . get_the_title( $avn_negar['menu_page'] ) . '</a></br>';
			}
			?>
		</div>
        <div class="menu-bottom-widget">
			<?php
			if ( ! empty( $avn_negar['menu_contact'] ) ) { ?>
				<div class="sidebarcontact">
					<?php
					foreach ( $avn_negar['menu_contact'] as $number ) {
						$formated_number = explode( "-", $number );
						echo '<a href="tel:' . $formated_number[0] . $formated_number[1] . '"><span class="phone_code">' . $formated_number[0] . '</span>' . ' - ' . $formated_number[1] . '</a></br>';
					}
					?>
				</div>
			<?php } ?>

            <?php if ($avn_negar['night_mode_activation']==1){ ?>
			<div class="single-settings">
                <div class="data-content">
                    <div class="toggle-button-cover">
                        <div class="button r">
                            <input class="checkbox" id="darkSwitch" type="checkbox" >
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
           
        </div>
    </div>
</div>
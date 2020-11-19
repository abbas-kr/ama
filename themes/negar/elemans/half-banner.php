<?php if (!defined('ABSPATH')) exit;
$avn_option = getSetting();
?>
<div class="half-banner">
    <?php
    foreach ($avn_option['banners_half'] as $banner) {
        if ($banner['attachment_id'] == $theId) {
            if (!empty($banner['url'])) {
                echo '<a href="' . $banner['url'] . '"><img src="' . $banner['image'] . '"></a>';
            } else {
                echo '<img src="' . $banner['image'] . '">';
            }
        }
    }
    ?>
</div>

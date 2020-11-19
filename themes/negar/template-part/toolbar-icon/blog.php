<li <?php echo ( is_singular( 'post' ) ) ? 'class="active"' : ''; ?>>
    <a href="<?= get_permalink(get_option('page_for_posts')) ?>" class="tab-link">
        <i class="fal fa-edit"></i><p>وبلاگ</p>
    </a>
</li>

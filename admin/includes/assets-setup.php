<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_footer', 'ibup_assets');
add_action('wp_enqueue_scripts', 'ibup_assets_tag');

function ibup_assets_tag() {
    if (ibup_is_activated()) {
        // increase compatibility with older PHP versions
        $hosts = join(',', array_map(function($host) {
            return '\'' . $host. '\'';
        }, ibup_get_authorised_hosts()));

        $source = htmlspecialchars(ibup_get_source(), ENT_QUOTES, 'UTF-8');
?>
<script type="text/javascript">
window.ImageBoss = {
    matchHosts: [<?php echo $hosts; ?>],
    source: "<?php echo esc_js( $source ); ?>",
<?php if (ibup_is_lazyload_activated()) { ?>
    srcPropKey: "data-src",
    format: 'auto',
    srcsetPropKey: "data-srcset",
    lowsrcPropKey: "data-lowsrc"
<?php } ?>
};
</script>
<?php
    }
}

function ibup_assets() {
    if (ibup_is_activated()) {
        wp_enqueue_script( 'imageboss-web', plugin_dir_url(__FILE__) . '../../public/js/imageboss-web-5.1.4.min.js', array(), '5.1.4', true );
        if (ibup_is_lazyload_activated()) {
            wp_enqueue_script( 'lazysizes', plugin_dir_url(__FILE__) . '../../public/js/lazysizes.min.js', array(), '5.3.2', true );
        }
    }
}

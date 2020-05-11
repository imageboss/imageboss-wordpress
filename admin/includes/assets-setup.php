<?php

add_action('wp_footer', 'ibup_assets_js');
function ibup_assets_js() {
    if (ibup_is_activated()) {
        // increase compatibility with older PHP versions
        $hosts = join(',', array_map(function($host) {
            return '\'' . $host. '\'';
        }, ibup_get_authorised_hosts()));

        $source = htmlspecialchars(ibup_get_source(), ENT_QUOTES, 'UTF-8');

        echo '
    <script type="text/javascript">window.ImageBoss = {matchHosts: [' . $hosts . '], source: "'. $source .'"};</script>
    <script src="//cdn.jsdelivr.net/gh/imageboss/imageboss-web@4.1.1/dist/imageboss.min.js" type="text/javascript"></script>
        ';
    }
}

<?php

add_action('wp_footer', 'ibup_assets_js');
function ibup_assets_js() {

    // increase compatibility with older PHP versions
    $hosts = join(',', array_map(function($host) {
        return '\'' . $host. '\'';
    }, ibup_get_authorised_hosts()));

    echo '
        <script type="text/javascript">window.ImageBoss = {authorisedHosts: [' . $hosts . ']};</script>
        <script src="//cdn.jsdelivr.net/gh/imageboss/imageboss-web@3.0.1/dist/imageboss.min.js" type="text/javascript"></script>
    ';
}

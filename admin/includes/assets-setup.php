<?php

add_action('wp_footer', 'ibup_assets_js');
function ibup_assets_js() {
    $hosts = json_encode(ibup_get_authorised_hosts(), JSON_UNESCAPED_SLASHES);

    echo '
        <script type="text/javascript">window.ImageBoss = {authorisedHosts: ' . $hosts . '};</script>
        <script src="//cdn.jsdelivr.net/gh/imageboss/imageboss-web@2.0.1/dist/imageboss.min.js" type="text/javascript"></script>
    ';
}

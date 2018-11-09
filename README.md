[![ImageBoss logo](https://img.imageboss.me/width/180/https://imageboss.me/emails/logo-2@2x.png)](https://imageboss.me)

# ImageBoss Plugin for Wordpress

Official Wordpress plugin for ImageBoss.
[https://imageboss.me/](https://imageboss.me/)

This plugin allows you to automatically serve all your image files via ImageBoss service which will give you:
* Content Aware Image Cropping.
* Up to 60% smaller images.
* WebP Detection.
* Face Detection.
* Animated GIFs.
* Progressive Scans.
* Image CDN.
* Image Filters.
* Watermarking.

## Manual Installation
Installing "WordPress ImageBoss Plugin" can be done either by searching for "ImageBoss" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via https://github.com/imageboss/imageboss-wordpress/raw/master/imageboss-plugin.zip
2. Upload the ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard
3. Activate the plugin through the 'Plugins' menu in WordPress

## Features

### Activating CDN features
When you install the plugin this is disable by default. Go to your Dashboard -> ImageBoss -> Settings and activate.

[![Settings](./imageboss-plugin/assets/settings.png)](https://imageboss.me)

### Adding Images With Custom Configuration
[![Features](./imageboss-plugin/assets/add-media-widget.png)](https://imageboss.me)

### Using ImageBoss on your theme
```html
<img
  src="http://www.yourwordpresssite.com/wp-content/uploads/2016/05/01.jpg"
  imageboss-operation="cover"
  cover-mode="smart"
  imageboss-width="500"
  imageboss-height="500"
  imageboss-options=""
/>
```
We will render your image according to your params.

## Tested on
WordPress
  - 4.9.x

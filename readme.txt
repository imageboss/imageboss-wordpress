=== ImageBoss - Image Optimization & CDN ===
Contributors: igorescobar
Tags: cdn, webp, image compression, lazy load
Requires at least: 4.0
Requires PHP: 5.3.0
Tested up to: 6.8
Stable tag: 5.0.2
License: MIT
License URI: https://opensource.org/licenses/MIT

Optimize your images with compression, CDN delivery, and responsive images through the ImageBoss service.

== Description ==

= Plugin Features =
* WooCommerce Compatible.
* Compression, CDN and Progressive Scans to all your images automatically.
* Free Bandwidth included in your plan.
* Retina Displays Support.
* Lazy loading.

= API Features =

Content aware image resizing, cropping, compression, cache and CDN. All web development practices, hassle free in one simple and powerful API.

* Content Aware Image Cropping.
* Image compression.
* Lazy loading.
* WebP Detection.
* Face Detection.
* Animated GIFs.
* Progressive Scans.
* Image CDN.
* Image Filters.
* Watermarking.

Your WordPress Themes are now even more powerful and flexible.

== Installation ==

Installing "ImageBoss WordPress Plugin" can be done either by searching for "ImageBoss" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via [WordPress.org Plugins](https://wordpress.org/plugins/imageboss).
1. Upload the ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to the Plugin Settings and follow the instructions.
1. Make sure you clean your cache if you have any caching-related plugins installed.

== External Service ==

This plugin connects to the ImageBoss image optimization service to process and deliver your images.

= What is ImageBoss? =
ImageBoss is an external image optimization and CDN service that processes your images on-the-fly. When activated, this plugin rewrites your image URLs to route them through ImageBoss servers, which then optimize and deliver your images.

= Data Sent to ImageBoss =
When this plugin is active, your image URLs are transformed to be served through ImageBoss. This means:
* Your original image URLs are sent to ImageBoss servers
* ImageBoss fetches, optimizes, and caches your images
* Optimized images are delivered to your visitors via the ImageBoss CDN

= Account Required =
To use this plugin, you need an [ImageBoss account](https://imageboss.me/). By using this plugin, you agree to the ImageBoss [Terms of Service](https://imageboss.me/legal/terms) and [Privacy Policy](https://imageboss.me/legal/privacy).

= Service Links =
* Service: [https://imageboss.me/](https://imageboss.me/)
* Terms of Service: [https://imageboss.me/legal/terms](https://imageboss.me/legal/terms)
* Privacy Policy: [https://imageboss.me/legal/privacy](https://imageboss.me/legal/privacy)

== Changelog ==

= 5.0.2 =
* Fixed: Added proper sanitization callbacks for all settings
* Fixed: Replaced PHP short tags with full PHP tags for better compatibility
* Fixed: Included ImageBoss Web library locally instead of loading from CDN
* Fixed: Added direct file access prevention to all PHP files
* Fixed: Secured uninstall process with proper WP_UNINSTALL_PLUGIN check
* Fixed: Updated External Service documentation for WordPress.org compliance
* Updated: ImageBoss Web library to version 5.1.4
* Updated: Tested with WordPress 6.8

= 5.0.1 =
* Initial release on WordPress.org

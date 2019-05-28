=== Premmerce Dev Tools ===
Contributors: premmerce
Tags: developers tools, code debug, debugging, wordpress debugging, plugin generator, data generator, database cleaner, data cleaner
Requires at least: 4.8
Tested up to: 5.2
Stable tag: 2.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is created to facilitate the development, testing and debugging of the code on the WordPress platform and to quickly create the demo data for WooCommerce.


== Description ==

This plugin is aimed at making it easier to develop, test and debug the code on the WordPress platform.
We created this plugin based on our research: [Wordpress Development Environment and Developers Best Practices Review](https://premmerce.com/wordpress-development-environment-developers-best-practices-review/)

= Major features in “Premmerce Dev Tools” =

* Integration of symfony/var-dumper for debugging the code
* Integration symfony/stopwatch for the execution time checking
* Generating the test data for WooCommerce
* Plugin generator, which creates the basic files structure
* Database clean up

= Compatibility with other Plugins =

* WooCommerce

= Installation =

1. Unzip the downloaded zip file.
1. Upload the plugin folder into the ‘wp-content/plugins/’ directory of your WordPress site.
1. Activate ‘Premmerce Dev Tools’ from Plugins page

== Screenshots ==

1. Plugin generator
2. Data generator
3. Data cleaner


== Documentation ==

Full documentation is available here: [Premmerce Dev Tools](https://premmerce.com/premmerce-dev-tools/)

== Changelog ==

= 1.0 =

Release Date: Sep 05, 2017

* Initial release

= 1.0.1 =

Release Date: Sep 25, 2017

* Fixed a bug with wrong translation domain
* Added renderTemplate method to FileManager
* Updated symfony/var-dumper v3.3.8 => v3.3.9
* Updated symfony/stopwatch v3.3.8 => v3.3.9

= 1.0.2 =

Release Date: Sep 25, 2017

* Fixed plugin name property in FileManager

= 1.1 =

Release Date: Mar 20, 2018

* Updated symfony/stopwatch (v3.3.9 => v3.4.6)
* Updated symfony/var-dumper (v3.3.9 => v3.4.6)
* Updated stubs for Plugin generation
* Updated autoload in Plugin generator - now composer usage is required
* Updated initial readme generation
* Added premmerce/wordpress-sdk
* Removed autoload.php

= 2.0 =

Release Date: Jun 5, 2018

* Updated premmerce/wordpress-sdk
* Added brands generator
* Added brands cleaner
* Added tags cleaner
* Added nesting categories
* Updated category names generation
* Updated attributes names generation
* Fixed term counts
* Fixed product date

=== Social Network Widget ===
Contributors: mahdiyazdani, mypreview, gookaani
Tags: social profiles, social icons, social media, social networks, widget, icons
Donate link: https://www.mypreview.one
Requires at least: 5.0
Tested up to: 5.3.1
Requires PHP: 7.2
Stable tag: 1.1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A simple customizable social networks widget for your sidebars.

== Description ==
A simple widget that allows you easily add icons for the most popular social networks to your sidebar or other widget area.

== Installation ==
= Minimum Requirements =

* PHP version 7.2 or greater.
* MySQL version 5.6 or greater or MariaDB version 10.0 or greater.
* WordPress version 5.0 or greater.

= Automatic installation =

Automatic installation is the easiest option — WordPress will handle the file transfer, and you won’t need to leave your web browser. To do an automatic install of the plugin, log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New.”
 
In the search field type “Social Network Widget”, then click “Search Plugins.” Once you’ve found the plugin, you can view details about it such as the point release, rating, and description. Click “Install Now,” and WordPress will take it from there.

= Manual installation =

The manual installation method requires downloading the plugin and uploading it to your webserver via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation "Manual plugin installation").

= Updating =

Automatic updates should work smoothly, but we still recommend you back up your site.

== Frequently Asked Questions ==
= How do I use the plugin? =
1. Log into your WordPress website and navigate to Appearance » Widgets.
2. Locate the Social Network widget and drag it to the sidebar area where you wish it to appear.
3. Click the down arrow in the upper right corner to expand the widget’s interface.
4. For each social media account you want to add, click on “Add an icon” button and then enter the URL for the social media account.
4. Then click the Save button to save the widget’s customization.
5. Preview the site. You should now see the added social widget is visible.

= How does the widget knows which icon to display? =
The answer is in the URL. If “facebook.com” is in the URL, the Facebook icon will be displayed. Likewise, if “twitter.com” is in the URL, the Twitter icon is going to be displayed instead. And so on.

= Can I reorder the icons? =
Yes, social account URLs can be reordered or sorted by dragging and dropping within the widget’s interface.

= Can I add an icon? =
Yes, custom icons can be added with the use of the following filter:
`
function prefix_custom_social_icon( $supported_icons ) {
    $supported_icons[] = array(
        'url' => array( 'example.com' ),
        'label' => 'Example',
        'icon' => '' // Your SVG icon
    );

    return $supported_icons;
} 
add_filter( 'social_network_widget_supported_icons', 'prefix_custom_social_icon', 10, 1 );
`

= Which icons are supported? =
Linking to any of the following sites in your social network widget will automatically display its icon in your sidebar area:

* 500px
* Amazon
* Behance
* CodePen
* DeviantArt
* Dribbble
* Dropbox
* Etsy
* Facebook
* RSS Feed
* Flickr
* Foursquare
* Goodreads
* Google
* GitHub
* Instagram
* Last.fm
* LinkedIn
* Email
* Meetup
* Medium
* Pinterest
* Pocket
* Reddit
* Skype
* Snapchat
* SoundCloud
* Spotify
* Tumblr
* Twitch
* Twitter
* Vimeo
* VK
* WordPress
* Yelp
* YouTube

NOTE — The rights to each pictogram (icon) in this plugin are either trademarked or copyrighted by the respective company.

= How do I get help with the plugin? =
The easiest way to receive support is to “Create a new topic” by visiting Community Forums page [here](https://wordpress.org/support/plugin/social-network-widget "Social Network Widget Support Forum").

Make sure to check the “Notify me of follow-up replies via email” checkbox to receive notifications, as soon as a reply posted to your question or inquiry.

*Please note that this is an opensource 100% volunteer project, and it’s not unusual to get reply days or even weeks later.*

= Can I help in translating this plugin into a new language? =
The plugin is fully translation-ready and localized using the GNU framework, and translators are welcome to contribute to the plugin.

Here’s the [WordPress translation website &#8594;](https://translate.wordpress.org/projects/wp-plugins/social-network-widget "WordPress translation website")

= How do I contribute to this plugin? =
We welcome contributions in any form, and you can help reporting, testing, and detailing bugs.

Here’s the [GitHub development repository &#8594;](https://github.com/mypreview/social-network-widget "GitHub development repository")

= Did you like the idea behind this plugin? =
Please share your experience by leaving this plugin [5 shining stars](https://wordpress.org/support/plugin/social-network-widget/reviews/ "Rate Social Network Widget 5 stars") if you like it, thanks!

= I need help customizing this plugin? =
Professional engineer and independent creative technologist in tech · over 6 years experience working from prototype to production · developing WordPress products, services, and eCommerce solutions.

[Available for hire &#8594;](https://mahdiyazdani.com "Mahdi Yazdani’s personal website")

== Screenshots ==
1. Widget settings interface

== Changelog ==
= 1.1.0 =
* Multiple code standards improvements.
* Compatibility with WordPress 5.5

= 1.0.0 =
* Initial release.
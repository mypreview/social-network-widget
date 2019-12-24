=== Social Network Widget ===
Contributors: mahdiyazdani, mypreview, gookaani
Tags: social media widget, social icons, follow us widget, social button, social follow widget
Donate link: https://www.mypreview.one
Requires at least: 5.0
Tested up to: 5.3.1
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple customizable social networks widget for your sidebars.

== Description ==
A simple widget that allows you easily add icons for the most popular social networks to your sidebar or other widget area.

**Translators & Non-English Speakers**

Translators are welcome to contribute to the plugin. Please use the [WordPress translation website](https://translate.wordpress.org/projects/wp-plugins/social-network-widget "WordPress translation website").

**Get Involved**

Want to contribute? Here's the [GitHub development repository](https://github.com/mypreview/social-network-widget "GitHub development repository").

**Free Support**

All support is handled via a dedicated support forum, available at [Community Forums](https://wordpress.org/support/plugin/social-network-widget "Community Forums"). Please head out there to open a new topic, in case you have any questions.

**Support this plugin**

Don't forget to rate this plugin [5 shining stars](https://wordpress.org/support/plugin/social-network-widget/reviews/ "5 shining stars") if you like it, thanks!

== Installation ==
= Minimum Requirements =

* PHP 7.2 or greater is recommended
* MySQL 5.6 or greater is recommended

= Automatic installation =

Automatic installation is the easiest option — WordPress will handles the file transfer, and you won’t need to leave your web browser. To do an automatic install of the plugin, log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New.”
 
In the search field type “Social Network Widget,” then click “Search Plugins.” Once you’ve found us,  you can view details about it such as the point release, rating, and description. Most importantly of course, you can install it by! Click “Install Now,” and WordPress will take it from there.

= Manual installation =

Manual installation method requires downloading the plugin plugin and uploading it to your web server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation "Manual plugin installation").

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

= I need help customizing this plugin? =
I am a full-stack developer with over five years of experience in WordPress theme and plugin development and customization. I would love to have the opportunity to discuss your project with you.
[Hire me at UpWork &#8594;](https://www.upwork.com/o/profiles/users/_~016ad17ad3fc5cce94/ "Mahdi Yazdani Freelancer Profile")

== Screenshots ==
1. Widget settings interface
2. “Follow Us” widget visible on Hypermarket theme’s footer.

== Changelog ==
= 1.0.0 =
* Initial release.
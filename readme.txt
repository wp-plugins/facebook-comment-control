=== Plugin Name ===
Contributors: Marco Scheffel 'Unl3a5h3r'
Special thanks to: Gil Goldshlager, 'pingflood' & 'TH_Wesley
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=N6E42VW26QD66
Tags: comments, spam, facebook, social plugin, social network
Requires at least: 2.7
Tested up to: 3.1
Stable tag: 0.1

You have replaced the default Wordpress comments template with the Facebook <fb:comments>? Then this plugin is what you need!

== Description ==

You have replaced the default Wordpress comments template with the Facebook <fb:comments>? Then this plugin is what you need!

= What the Plugin can do: =
* List all comments on your blog with dashboard widget
* Delete comments
* See where the comments were posted
* See who posted the comments
* Display the overview for specific roles only
* Write a message to the commentator

= What the plugin cannot do (To-Do-List): =
* Let you comment

Special thanks go to: Gil Goldshlager, 'pingflood' & 'TH_Wesley  from the Facebook developers forum

== Installation ==

1. Extract 'facebook-comment-control.zip' to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the settings page under 'Settings | Facebook Comment Control' and specify your Application ID, your Secret Key and your profile UID (NOT the username. Check: http://www.youtube.com/watch?v=DWYOMPd0Yco)

== Frequently Asked Questions ==

= I have installed the plugin according to the manual, but I get an error like =
= 'Warning: file_get_contents(https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=YOUR_APP_ID&client_secret=YOUR_SECRET) [function.file-get-contents]: failed to open stream: No such file or directory' =

Your server might be behind a proxy.
* Just visit the page mentioned in the error code (https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=YOUR_APP_ID&client_secret=YOUR_SECRET)
* Copy the code after 'access_token='
* Go back to the settings page of Facebook Comment Control and put that code into the field 'Custom token'
* Save and everything should work

= Why do I only get a blue bar and a placeholderimage on my dashboard. =

Have you set up the Facebook application correctly?
Go to Facebook -> Developers app -> Edit my apps -> edit 'the app for your blog' -> Connect -> Connect-URL must be Blog-URL


== Screenshots ==

1. dashboard widget - light style
1. dashboard widget - dark style
1. settings page

== Changelog ==
= 0.3 =
* send message via plugin
* configure userlevel to see the widget

= 0.2 =
* delete link now only for app-admins
* fixed some css issues
* xid below comment is a link if you use id or urlencode(the_permalink()) as xid

= 0.1 =
* stable release
* added dark layout option
* added language option

= 0.1beta =
* release

== Upgrade Notice ==
= 0.3 =
* more security through userlevel control

= 0.2 =
* the old css bugged the dashboard, so please update
* plugin is more secure, because only admins can delete comments

= 0.1 =
* first stable release

= 0.1beta =
* release
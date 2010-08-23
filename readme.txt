=== Plugin Name ===
Contributors: Unl3a5h3r
Special thanks to: Gil Goldshlager, 'pingflood' & 'TH_Wesley
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=N6E42VW26QD66
Tags: comments, spam, facebook, social plugin, social network
Requires at least: 2.7
Tested up to: 3.1
Stable tag: 0.6

You have replaced the default Wordpress comments template with the Facebook fb:comments? Then this plugin is what you need!

== Description ==

You have replaced the default Wordpress comments template with the Facebook fb:comments? Then this plugin is what you need!

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
= 'Warning: file_get_contents(URL) [function.file-get-contents]: failed to open stream: No such file or directory' =

Your server might be behind a proxy.
* Just visit the page mentioned in the error code (https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=YOUR_APP_ID&client_secret=YOUR_SECRET)
* Copy the code after 'access_token='
* Go back to the settings page of Facebook Comment Control and put that code into the field 'Custom token'
* Save and everything should be fine

= Why do I only get a blue bar and a placeholderimage on my dashboard. =

Have you set up the Facebook application correctly?
Go to Facebook -> Developers app -> Edit my apps -> edit 'the app for your blog' -> Connect -> Connect-URL must be Blog-URL


== Screenshots ==

1. dashboard widget - light style
1. dashboard widget - dark style
1. settings page

== Changelog ==
= 0.6 =
* Added localization
* Minor bugfixung

= 0.5 =
* Message link not displayed for app admin
* Compressed .css files
* Compressed .js files
* Fixed readme file

= 0.4 =
* Minor bugfixes

= 0.3.1 =
* Message links works again
* Message link only for Facebook users
* Names will be displayed again

= 0.3 =
* Paging now works thanks to Gil

= 0.2.4 =
* finally got updating working

= 0.2.3 =
* new readme

= 0.2.2 =
* new readme

= 0.2.1 =
* new screenshots

= 0.2 =
* Message link only appears for facebook-users

= 0.1 =
* stable release
* added dark layout option
* added language option
* delete link now only for app-admins
* fixed some css issues
* xid below comment is a link if you use id or urlencode(the_permalink()) as xid
* send message via plugin
* configure userlevel to see the widget

= 0.1beta =
* release


== Upgrade Notice ==
= 0.6 =
Finally true localization. Feel free to send me new .mo files (French,...)

= 0.3.1 =
Lots of error-fixing

= 0.3 =
Paging now works thanks to Gil


== Known Issues ==

* The paging links display always. First should not be displayed on first page and last not on last page

NOTE: The following are all issues with the Facebook library itself. They are out of my control.

* The Facebook API has no 'block user' method so I cannot add it

== Upcoming Features ==

* More localization (need help here, please contact me)
* More styling
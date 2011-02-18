=== Plugin Name ===
Contributors: Unl3a5h3r
Special thanks to: Gil Goldshlager, 'pingflood' & 'TH_Wesley'
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=N6E42VW26QD66
Tags: comments, spam, facebook, social plugin, social network
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 2.2

Development stopped

== Description ==

Development stopped

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

1. dashboard widget
1. sidebar widget
1. settings page

== Changelog ==
= 2.1 =
* bugfix for windows servers

= 2.0 =
* fbcomcon runs in an iframe now grants compatibility with Facebook Like Count (my other plugin)
* lots of bugfixes

= 1.4 =
* deleted some useless *** from the facebook css part

= 1.3 =
* css bugfixes

= 1.2.1 =
* fix

= 1.2 =
* Bugfixing
* Code cleaning

= 1.1 =
* Important security bugfixes
* Removing dark layout

= 1.0 =
* New sidebar widget with last 5 posts
* Some bugfixes

= 0.7 =
* Bugfixing
* Link to Comment page now via unescape() => Should speed things up for blogs with many articles
* Cleaned some useless css code

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
= 2.1 =
Plugin was bugged on windows servers. So please update.

= 2.0 =
Please update. Dashboard widget now runs in an iframe to grant compatibility with <a href="http://fblico.mafact.de/">Facebook Like Count</a> or other javascript widgets.

= 1.3 =
Have notices some css bug. So please update immediately

= 1.1 =
Please update: Important security bugfixes

= 1.0 =
New sidebar widget to show recent comments. More configurations options will follow

= 0.7 =
Important bugfixing. Please update

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
* Comments can only be fetched for users that are logged in to facebook and have connected with your app. Therefor recent comments can only be shown for those users.

== Upcoming Features ==

* More localization (need help here, please contact me)
* More styling
* More configuration options to the sidebar widget
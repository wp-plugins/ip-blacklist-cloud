=== IP Blacklist Cloud ===
Contributors: ad33lx
Donate link: 
Tags: comments, spam, IP, blacklist, cloud, IP cloud, block, spamming, secure
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



Blacklist IP Addresses from visiting your WordPress website and Usernames from spamming!!


== Description ==

IP Blacklist Cloud plugin allows you to blacklist IP addresses from visiting your WordPress website. Also, it submits your website link to the blocked IP database on [http://ip-finder.me](http://ip-finder.me/) which gives the other users to view how many sites have blocked the specific IP and see their comments.
New feature has been added to plugin which allows you to block usernames from spamming (comments) on your website.


Premium Service (Cloud Account) is no more available on our server. Now you can use Import / Export function.


== Installation ==

Note: Before downloading and installing plugin, you must accept that plugin sends your website url (using site_url()), website name (using get_bloginfo(‘name’)) automatically when you blacklist any IP to http://ip-finder.me and show this on relative blacklisted IP. (Example: http://ip-finder.me/wpip?IP=203.81.202.127)

SpamChecker sends comments data (Name, Email, URL and Comment) to check Spam Percentages based on our database.


1. Upload `ip_blacklist_cloud` folder to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

== How Does it Work ==

1. If you want to block an IP manually, you can do this by providing IP in admin menu “IP Blacklist->Add IP to Blacklist”.

2. If any visitor or spamming bot post comment on your posts, by visiting “Comments” menu you can view IP and details on ip-finder.me or blacklist the IP.

For example: http://ip-finder.me/wpip?IP=203.81.202.127

3. Once you black list the IP address, the visitor will not be able to view any content of your website and also post your website link and name on IP Finder cloud.

4. You can delete any IP from blacklist by visiting admin menu “IP Blacklist->Blacklist” and it will also remove your site link and name from the list of websites which have blocked that specific IP.

5. You can leave comments on IP Cloud (example: http://ip-finder.me/wpip?IP=203.81.202.127 ) so that other users can get the idea why this IP have been blocked by your site.

== Frequently asked questions ==

Q1. What data does this plugin submits to http://ip-finder.me/
Ans: * This plugin submits your WordPress site url and site name.
     * Version 1.1 sends pending comment to http://ip-finder.me/ and find the same comment if it was posted on any other WordPress websites who have installed this plugin.
     * Sending comment details to cloud requires user action and it is not automatic.

Q2. Why does it sends WordPress site url and site name?
Ans: In order to build this IP Cloud valuable to all the users, ip-finder.me save site name and site url only for specific IP (when you block it) so that it gives the attention to other users that this IP could be dangerous for their website.

Q3. How and when does it sends data to ip-finder.me
Ans: Plugin sends the data only on two conditions:

  1. When you blacklist any IP on your website, it saves the data on ip-finder.me and add your site to the list of websites who have blocked that specific IP.
  2. When you delete any IP from blacklist, it sends request to ip-finder.me to remove your site from the list of websites who have blocked that specific IP.
  3. When you request to check Spam Percentage of any comment.


Q4. If we block any IP, can they access example.com/wp-admin or still post comments?
Ans: NO! This is the main reason why this plugin has been built to avoid spamming on WordPress based websites. you can test this on demo server (Please see Demo section below)

Q6. What data does it sends for checking spam percentage of a comment?
Ans: It sends Name, Email, URL and the contents of the comments.

Q7. What data do you keep in your database?
Ans: We keep details of 

	* Blacklist IPs
	* Blacklisted Usernames
	* Websites' names and URLs who have blocked that specific IP address
	* Comments details on which users have doubt that they are SPAM.

== Screenshots ==

1. http://demo.ip-finder.me/wp-content/uploads/2012/08/ip_box.png

== DEMO ==

You can test this plugin before downloading and installing on demo server.
http://demo.ip-finder.me/demo-details/


== Changelog ==


= 1.7 =
* Cloud Account (Premium) function has been disabled due to problems in connecting with our server.
* Import / Export option added in Settings page.
* Ajax blacklist function for IP and Username added on Comments page. Page will not refresh anymore.
* Sorting option added on IP Blacklist and Username Blacklist page. You can now check Blacklisted IP or Usernames visits after they are blocked. 
* Fixed Auto posting of comments to our server for spam check.

= 1.6 =
* Fixed Cloud Account functions for directory based WordPress websites.

= 1.5 =
* Fixed "Delete IP" function on IP Blacklist page.
* Blacklist Usernames to avoid spamming from same user on your website.
* Visit counter for both IP and Usernames has been added on their respective menu pages.
* PREMIUM SERVICE option has been added on settings pages of IP Blacklist plugin. (See details at: http://ip-finder.me/cloudaccount/ )

= 1.4 =
* Spam Checker bugs fixed for posting comments to IP Blacklist Cloud.
* Auto submit comment to IP Blacklist Cloud when visitor post any comment to your website (You can turn off this feature).

= 1.3 =
* Blacklist statistics page added in Admin Panel.

= 1.2 =
* Fixed Blacklist option on "Comments" Page for non-subdomain WordPress websites.

= 1.1 =
* Find Spam Pecentage of any pending comment by posting details to http://ip-finder.me/

= 0.1 =
* Initial Release


== Upgrade Notice ==

= 1.7 =
* Cloud Account (Premium) function has been disabled due to problems in connecting with our server.
* Import / Export option added in Settings page.
* Ajax blacklist function for IP and Username added on Comments page. Page will not refresh anymore.
* Sorting option added on IP Blacklist and Username Blacklist page. You can now check Blacklisted IP or Usernames visits after they are blocked. 
* Fixed Auto posting of comments to our server for spam check.


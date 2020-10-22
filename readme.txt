=== UpgradePath ===

Contributors: upgradepath
Donate link: https://upgradepath.io
Tags: update, upgrade, up-to-date, automation, plugins
Requires at least: 5.0
Tested up to: 5.5
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The UpgradePath wordpress integration sends plugin meta information to UpgradePath so that you can easily manage your software versions in one central place.

== Description ==

To use this plugin you will first need an UpgradePath account. UpgradePath is a platform that helps developers and sysadmins with managing the versions of software.

== Installation ==

Please install through the WordPress plugin directory.

== Configuration ==

1. Register at [upgradepath.io](https://upgradepath.io)
1. Create a WordPress integration and copy the API key
1. In your WordPress instance go to Settings -> UpgradePath
1. Paste the API key into the "New API key" field

This should be enough. If you need help connecting your WordPress instance with UpgradePath feel free to connect our support team.

== Frequently Asked Questions ==

= How often is the plugin sending a list of all installed plugins to UpgradePath? =

After the initial sync during the setup, every day and when you install or update a plugin.

= What meta information are you sending to UpgradePath? =

 * Plugin slug
 * Version tag

= Does this plugin work if the wordpress instance is not publicly accessible? (f.e. basic auth protected or locally installed) =

The plugin works even then, because UpgradePath is not directly accessing your WordPress instance, your instance is only sending information to UpgradePath.
This is why the WordPress instance only needs internet access.

== Screenshots ==

1. WordPress settings

== Changelog ==

= 0.0.1 =
* Initial release

== Upgrade Notice ==

= 0.0.1 =

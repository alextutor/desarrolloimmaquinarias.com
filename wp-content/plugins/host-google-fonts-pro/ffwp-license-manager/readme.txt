=== FFW.Press License Manager ===
Contributors: DaanvandenBergh
Tags: FFWP, licensing, management
Requires at least: 5.1
Tested up to: 5.8
Stable tag: 1.6.1
Requires PHP: 7.0

== Description ==

Plugin for managing FFW.Press Licenses and automatic updates for FFW.Press Plugins.

== Upgrade Notice ==

= 1.4.1 =
The previous release included safer storage of your license keys. A bug introduced double encyption for some license keys. 

If you're not receiving any more updates for your premium plugins, please re-activate your license keys after this update.

= 1.3.0 =
WoOSH! is renamed to Fast FW Press (FFWP). Due to major re-factors in the code, this plugin needs to be re-activated after updating.

== Changelog ==

= 1.6.1 =
* Enhancement: Don't save license key, if license key is invalid.
* Fix: The last update caused the JS to no load anymore, that's fixed now.

= 1.6.0 =
* Enhancement: Links in the renewal notice now take you to checkout immediately.
* Feature: this plugin now sports a more white label approach. The license manager can now be approached from the Settings link in the Plugins screen, or the Manage License tab from without your premium plugin.
* Feature: License expiry and renewal warnings are now shown in the Plugins screen using WordPress' native warning bar.

= 1.5.1 =
* Simplified code to display license key expiry dates on License Management screen.
* Notice count is saved to transient (which refreshes daily) to improve performance.

= 1.5.0 | April 27th, 2021 =
* Show a bubble in the sidebar when a license will expire within 30 days or is expired.
* Clarified license notifications on License Management screen, with links to extra information.
* Minor performance improvements and code refactors.

= 1.4.1 | March 11th, 2021 =
* Fixed a bug where license keys would be encrypted twice. This broke automatic updates for some users. After installing this update, re-activating the license keys will fix the issue.

= 1.4.0 | February 16th, 2021 =
* License keys are now encrypted before they are stored in the database.
* Stored license keys are now masked before they are shown in the license manager screen to prevent unwanted redistribution of the key by anyone but the license holder.
* Licenses can now be deactivated for the current site from within the License Manager.
* Added migration scripts to update existing license keys.

= 1.3.1 | February 9th, 2021 =
* Updated code to reflect the change in domain name: ffw.press.

= 1.3.0 | September 15th, 2020 =
* WoOSH! is now renamed to Fast FW Press (Fast ForWard Press or FFWP). The name change has been processed into this plugin, so don't forget to re-activate this plugin after updating.
* Licenses can from now on be managed in the FFW.Press menu item.
* Improved performance of autoloader.
* FFW.Press License Manager now fully manages the updates of other FFW.Press plugins. Significantly reducing the memory footprint of other FFW.Press plugins.

= 1.2.4 =
* Fixed bug where Multi Site instances of WP using subfolders would be identified as separate domains.

= 1.2.3 =
* Fixed some notices and warnings.

= 1.2.2 =
* Improved UX for handling of multiple licenses.

= 1.2.1 =
* Fixed bug in license validation.

= 1.2.0 =
* Expiry information is now shown in the License Management screen, and
* A notice is shown in the plugins is screen when the license is about to expire.
* Better error handling for calls to the validation and register API.

= 1.1.5 =
* Validation requests are no longer cached.
* Minor code optimizations.

= 1.1.4 =
* Tested with older WP versions. FFW.Press License Manager requires at least WP 5.1 to run properly.

= 1.1.3 =
* Added link to Lost License page.

= 1.1.2 =
* Minor improvements.

= 1.1.1 =
* Added 'Manage Licenses' link in Plugins screen.

= 1.1.0 =
* URLs are now provided with registration and validation.

= 1.0.4 =
* Changed icon.

= 1.0.3 =
* Added icons to provide visuals with license registration.

= 1.0.2 =
* Use SSL for API calls is now required.

= 1.0.1 =
* Minor bugfixes.

= 1.0.0 =
* First Release!
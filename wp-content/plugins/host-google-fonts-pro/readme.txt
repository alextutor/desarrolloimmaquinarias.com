=== OMGF Pro ===
Contributors: DaanvandenBergh
Tags: OMGF Pro, Google Fonts, Host Fonts Locally
Requires at least: 5.3
Tested up to: 5.8
Stable tag: 3.0.2
Requires PHP: 7.0

== Description ==

Replace all Google Fonts in your webpages with locally hosted versions. Also removes preconnect, dns-prefetch and preload headers.

== Changelog ==

= 3.0.2 | October 5th, 2021 =
* Fix: Manual Mode works again when Advanced Processing is on.
* Fix: Empty Cache Directory broke down due to 3.0.1's dependency checks.
* Fix: Don't throw any more notices, when optimization is finished.
* Fix: When Automatic Optimization Mode hasn't processed the page yet, serve the original page, including Google Fonts.

= 3.0.1 | October 4th, 2021 =
* Fix: prevent unsupported operand types error, by using array_merge() instead of + operand.
* Fix: Properly check if all dependencies are installed and activated before activating OMGF Pro and loading Admin classes.

= 3.0.0 | September 29th, 2021 =
* Feature: Automatic Optimization Mode is completely revamped!
  1. It now runs by cron schedule, instead of upon page request. I.e. no more slow downs upon first pageload!
  2. The Optimize Fonts-tab now features a full-fledged management panel, allowing you to manually trigger cron-tasks, manage batch size, etc.
  3. AOM now updates you about its progress thru notices within the Admin area.
* Enhancement: reduced the amount of code running in the frontend by ~60%!
* Fix: when Advanced Processing is disabled, OMGF Pro's other features are still properly processed by the OMGF API (e.g. Combine & Dedupe)
* Enhancement: several code refactors, optimizations and UX tweaks.

= 2.5.3 | August 18th, 2021 =
* Enhancement: calls to OMGF's download API should include a nonce.

= 2.5.2 | August 17th, 2021 =
* Fix: "Too few arguments to function passthru_handle()" error would occur if OMGF Pro was updated to v2.5.1 before OMGF was updated to 4.5.2.
* Fix: "Uncaught Error: Function name must be a string" error.

= 2.5.1 | August 15th, 2021 =
* Enhancement: Added @font-face detection in local stylesheets to Google Fonts Processing (Pro).
* Fix: Fixed fatal error when OMGF was deactivated/removed, while OMGF Pro was active.
* Fix: Fallback Font Stacks are now properly added to local stylesheets.
* Enhancement: Huge performance boost! Reduced code footprint in frontend by ~33%. Instead of queueing and processing elements for removal and replacement seperately, it's now all done at once.
* Fix: Fixed several warnings and notices.
* Fix: (Rewritten) local stylesheets are now properly refreshed, after changes are made to Fallback Font Stacks.

= 2.5.0 | August 2nd, 2021 =
* Feature: Added Fallback Font Stack feature.
* Fix: Fixed warning when Relative URLs are used.
* Fix: When a manual Save & Optimize is triggered from within the Admin area, always regenerate the stylesheet.

= 2.4.0 | July 28th, 2021 =
* Feature: Include File Types allows you to specify which files to include in the stylesheet. If you used the WOFF2 Only option previously, this option is now set to only use WOFF2.
* Feature: CDN URL, Alternative Relative Path and Use Relative URLs are replaced by the Fonts Source URL option. Don't worry. All your settings in the previously mentioned options are properly translated/migrated to this option.
* Feature: Added AMP handling feature to allow proper fallback/remove behaviour of Google Fonts on AMP pages.
* Fix: In Manual mode, the frontend would sometimes fail to load the stylesheet early when unloads were used.

= 2.3.1 | July 5th, 2021 =
* Fix: WP Rocket (and other CSS optimization plugins) trigger OMGF Pro multiple times. We now skip out early, if the stylesheet is already added.
* Enhancement: Added compatibility with Smart Slider 3.5 new implementation of Google Fonts.
  * Note: As of this version, OMGF Pro is no longer compatible with Smart Slider versions older than 3.5.

= 2.3.0 | June 7th, 2021 =
* Feature: Added Exclude Post/Page IDs option
* Enhancement: Stylesheet is now properly placed after preloads and before other stylesheets in safe mode and default mode.
* Feature: Added @import handling within theme/plugin stylesheets (@font-face handling coming soon!)
* Fix: Webfont.js detection for default mode properly removes webfont.js objects (before a warning would be thrown)
* Allround speed/memory usage improvements.

= 2.2.1 | May 11th, 2021 =
* Improved performance in Automatic and Manual optimization mode.
* Improved CSS2 API handling.
* Improved Safe Mode's handling of Google Fonts.
* Several improvements and bugfixes.
* A proper warning is now displayed when attempted to activate this plugin, without OMGF being installed and active.

= 2.2.0 | April 23rd, 2021 =
* Added Safe Mode option, which is to be used if (default) Advanced Processing breaks styling on certain (or all) pages.
* Updated HTML5 validator.

= 2.1.4 | April 5th, 2021 =
* When in Automatic mode, only the selected preloads for the currently used stylesheet should be loaded (works with OMGF 4.3.2 and higher)

= 2.1.3 | April 4th, 2021 =
* When in Manual mode, the generated stylesheet is forced throughout all pages.

= 2.1.2 | March 17th, 2021 =
* Minor code optimization for Force Subsets option.

= 2.1.1 | March 10th, 2021 =
* Adding ?nomgf=1 to any URL will now temporarily bypass fonts optimization.

= 2.1.0 | March 6th, 2021 =
* Added support for Google Early Access Fonts. More info: https://fonts.google.com/earlyaccess

= 2.0.6 | February 1st, 2021 =
* Tested with WP 5.6

= 2.0.5 | December 22nd, 2020 =
* Add support for webfont.min.js.

= 2.0.4 | December 8th, 2020 =
* Fixed CSS2 support.
* Fixed detection and removal for @import statements.
* OMGF Pro now uses OMGF's fixed cache keys when unloads are used.

= 2.0.3 | October 7th, 2020 =
* **NOTICE: To use OMGFv4.2's Optimized Google Fonts overview it's required to Empty the Cache Directory first.**
* Compatibility fixes for OMGF 4.2.0's Optimization Mode and Do Not Load options.
* Cleaned up sidebar.

= 2.0.2 | October 1st, 2020 =
* Compatibility fixes for the way OMGF 4.1.3 handles notices.

= 2.0.1 =
* If Force Subsets wasn't set, OMGF Pro would throw a warning. This is fixed.

= 2.0.0 | September 30th, 2020 =
* OMGF Pro now detects and caches Google Fonts automatically, no more auto detect required. Even if you use different fonts on different pages, they'll be cached and served properly.
* OMGF Pro can now be temporarily disabled by disabling the Advanced Processing option under Settings > Optimize Google Fonts > Basic Settings.
* Using Subset Forcing, you can now force your theme/plugins to load all Google Fonts in a certain subset, further reducing Page Size and Load Time.
* All promotion for OMGF Pro is now removed after activating this plugin.
* Some Pro options are moved to Basic Settings and Advanced Settings, since Extensions tab is removed in OMGF 4.0.0.
* Increased compatibility with CSS Minify/Combine and Caching plugins, e.g. WP Fastest Cache, WP Rocket, WP Super Cache and Autoptimize plugins.

= 1.4.1 | September 15th, 2020 =
* Tested with WP 5.5.
* Removed Updater-classes and files, as updates are now fully managed by FFWP License Manager, significantly reducing the footprint of this plugin.
* Removed dependency of FFWP License Manager, since the two can now function fully autonomously.
* Performance improvements for class loader.

= 1.4.0 | August 16th, 2020 =
* Auto Remove Pro's behavior can now be fine tuned (within OMGF v3.8.0's Extensions tab) to speed up performance.

= 1.3.0 | July 31st, 2020 =
* OMGF Pro can now Auto Detect and Remove Google Fonts from inline stylesheets containing @font-face and @import rules.
* Minor code optimizations.
* Added dates to this changelog. :)

= 1.2.3 | July 19th, 2020 =
* Added compatibility for Smart Slider 3.
  * Smart Slider 3 users should disable Google Fonts in Smart Slider > Dashboard > Settings > Fonts > Google > Frontend [off] after running Auto Detect.
* Performance improvements.

= 1.2.2 | June 28th, 2020 =
* Fixed bug where OMGF Pro would attempt to process other documents besides valid HTML.

= 1.2.1 | June 21st, 2020 =
* Fixed bug where OMGF Pro would also process XML documents, breaking e.g. RSS feeds.

= 1.2.0 | June 10th, 2020 =
* Added support for synchronously loaded Web Font Loader.
* Added support for WebFontConfig added with base64 encoded string.
* Added a little 'eye candy' under Settings > Optimize Google Fonts, to make it more clear that OMGF Pro is enabled and functioning properly.

= 1.1.4 | June 7th, 2020 =
* OMGF Pro can now properly handle HTML5.
* Minor performance optimizations.

= 1.1.3 =
* Remove WebFontConfig script when Remove Google Fonts is enabled.

= 1.1.2 =
* Modify review and tweet link in notice after generating stylesheet to point to ffw.press.

= 1.1.1 =
* Fixed bug where Auto Detect would trigger on each page load.
* Auto Remove of DNS Prefetch, Preconnect and Preload works more accurately now.

= 1.1.0 =
* Added support for WebFont Loader.

= 1.0.0 | June 6th, 2020 =
* First Release!
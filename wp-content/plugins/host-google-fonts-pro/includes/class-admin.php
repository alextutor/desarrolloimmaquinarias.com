<?php

/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */

defined('ABSPATH') || exit;

class OmgfPro_Admin
{
	const ADMIN_JS_HANDLE            = 'omgf-pro-admin-js';
	const FFWP_BASE_URL              = 'https://ffw.press';
	const FFWP_OMGF_PRO_FAQ_LINK     = self::FFWP_BASE_URL . '/docs/omgf-pro/faq/';
	const FFWP_OMGF_PRO_SUPPORT_LINK = self::FFWP_BASE_URL . '/contact/';

	/** @var string $plugin_text_domain */
	private $plugin_text_domain = 'omgf-pro';

	/**
	 * OmgfPro_Admin constructor.
	 */
	public function __construct()
	{
		/** Admin-wide stuff. */
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);

		/** Add options for which a cache flush notice should be shown. */
		add_filter('omgf_admin_options_show_notice', [$this, 'add_show_notice_options'], 10, 1);

		/** Add license field to FFW.Press License Manager */
		add_filter('ffwp_license_manager_licenses', [$this, 'do_license_field'], 1, 1);

		/** Change links in documentation section. */
		add_filter('omgf_settings_sidebar_faq_link', function () {
			return self::FFWP_OMGF_PRO_FAQ_LINK;
		});
		add_filter('omgf_settings_sidebar_get_support_link', function () {
			return self::FFWP_OMGF_PRO_SUPPORT_LINK;
		});

		/**
		 * Enable Pro Options
		 */
		add_filter('omgf_optimization_mode_auto_setting_disabled', '__return_false');
		add_filter('omgf_pro_file_types_setting_disabled', '__return_false');
		add_filter('omgf_pro_force_subsets_setting_disabled', '__return_false');
		add_filter('omgf_pro_fallback_font_stack_setting_disabled', '__return_false');
		add_filter('omgf_pro_advanced_processing_setting_disabled', '__return_false');
		add_filter('omgf_pro_safe_mode_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_inline_styles_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_resource_hints_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_stylesheet_imports_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_stylesheet_font_faces_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_stylesheets_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_webfont_loader_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_process_early_access_setting_disabled', [$this, 'is_advanced_processing_enabled']);
		add_filter('omgf_pro_amp_handling_setting_disabled', '__return_false');
		add_filter('omgf_pro_excluded_ids_setting_disabled', '__return_false');
		add_filter('omgf_pro_source_url_setting_disabled', '__return_false');

		/** Remove promotional material and modify page title */
		add_filter('apply_omgf_pro_promo', '__return_false');
		add_filter('omgf_pro_promo', '__return_empty_string');
		add_filter('omgf_settings_page_title', [$this, 'do_page_title']);

		/** Add registration link to this plugin's row in plugins screen */
		add_filter('plugin_action_links_' . plugin_basename(OMGF_PRO_PLUGIN_FILE), [$this, 'registration_link']);

		/**  */
		add_filter('pre_update_option_omgf_pro_force_subsets', [$this, 'convert_selected_options'], 10, 2);
		add_action('update_option_omgf_cache_keys', [$this, 'maybe_flush_cache_keys'], 10, 2);
		add_action('delete_option_omgf_pro_automatic_mode_queue', [$this, 'show_queue_reset_notice']);

		$this->add_optimize_settings();
	}

	/**
	 * 
	 * @return void 
	 */
	private function add_optimize_settings()
	{
		new OmgfPro_Admin_Settings_Optimize();
	}

	/**
	 * Enqueues the necessary JS and CSS and passes options as a JS object.
	 *
	 * @param $hook
	 */
	public function enqueue_admin_scripts($hook)
	{
		if ($hook == 'settings_page_optimize-webfonts') {
			wp_enqueue_script(self::ADMIN_JS_HANDLE, plugin_dir_url(OMGF_PRO_PLUGIN_FILE) . 'assets/js/omgf-pro-admin.js', ['jquery', 'omgf-admin-js'], OMGF_PRO_STATIC_VERSION, true);
		}
	}

	/**
	 * when unload options have changed, flush cache keys and transients.
	 * 
	 * @since v2.2.2
	 * @since v3.0.0
	 */
	public function maybe_flush_cache_keys($old_keys, $keys)
	{
		if ($old_keys == $keys) {
			return $keys;
		}

		self::clear_cache_handles();

		return $keys;
	}

	/**
	 * Public method to clear cache handles from database (Multisite compatible)
	 */
	public static function clear_cache_handles()
	{
		if (is_multisite()) {
			$transient_label = OmgfPro_OptimizationMode_Automatic::TRANSIENT;
			$meta_key_label  = OmgfPro::OMGF_PRO_HANDLE_META_KEY;

			if (wp_is_large_network()) {
				OmgfPro_Admin_Notice::set_notice(
					sprintf(
						__('While trying to clear all stored stylesheet handles from the database, OMGF Pro detected that your multisite network exceeds 10.000 sites and wouldn\'t be able to finish the query properly. Please run an SQL query directly in your database to properly clear meta key <code>%s</code> from the <code>postmeta</code> and <code>termmeta</code> tables and the <code>%s</code> transient from the <code>options</code> tables.', self::$plugin_text_domain),
						$meta_key_label,
						$transient_label
					)
				);
			}

			global $wpdb;

			foreach (get_sites() as $site) {
				delete_blog_option($site->blog_id, OmgfPro::OMGF_PRO_HANDLE_OPTION_NAME);

				$wpdb->set_blog_id($site->blog_id);
				$wpdb->query("DELETE FROM '{$wpdb->prefix}options' WHERE 'option_name' LIKE ('{$transient_label}')");
				$wpdb->query("DELETE FROM '{$wpdb->prefix}postmeta' WHERE 'meta_key' = '{$meta_key_label}'");
				$wpdb->query("DELETE FROM '{$wpdb->prefix}termmeta' WHERE 'meta_key' = '{$meta_key_label}'");
			}
		} else {
			delete_option(OmgfPro::OMGF_PRO_HANDLE_OPTION_NAME);
			delete_option(OmgfPro_OptimizationMode_Automatic::QUEUE);
			delete_transient(OmgfPro_OptimizationMode_Automatic::TRANSIENT);
			delete_post_meta_by_key(OmgfPro::OMGF_PRO_HANDLE_META_KEY);
			delete_metadata('term', null, OmgfPro::OMGF_PRO_HANDLE_META_KEY, '', true);
		}
	}

	/**
	 * Show this notice whenever the queue option is deleted.
	 */
	public function show_queue_reset_notice()
	{
		OmgfPro_Admin_Notice::set_pro_notice(
			'<strong>' . __('OMGF Pro has reset the Automatic Optimization Queue and will process the changes by cron schedule. The cron task runs every two minutes. <a href="#" id="omgf-pro-run-cron-notice">Run now?</a>', $this->plugin_text_domain) . '</strong>',
			'info',
			'omgf-pro-automatic-mode-queue-reset'
		);
	}

	/**
	 * @param $new_options
	 * @param $old_options
	 *
	 * @return false|string
	 */
	public function convert_selected_options($new_options, $old_options)
	{
		$new_options = wp_json_encode($new_options);

		if ($new_options == $old_options) {
			return $old_options;
		}

		return $new_options;
	}

	/**
	 * @param $links
	 *
	 * @return string
	 */
	public function registration_link($links)
	{
		$adminUrl     = admin_url() . 'options-general.php?page=ffwp-license-manager';
		$settingsLink = "<a href='$adminUrl'>" . __('Enter License Key', $this->plugin_text_domain) . "</a>";
		array_push($links, $settingsLink);

		return $links;
	}

	/**
	 * @return string
	 */
	public function do_page_title()
	{
		return __('OMGF Pro', $this->plugin_text_domain);
	}

	/**
	 * @param $licenses
	 *
	 * @return array
	 */
	public function do_license_field($licenses)
	{
		$licenses[] = [
			'id'          => 4027,
			'label'       => __('OMGF Pro', $this->plugin_text_domain),
			'plugin_file' => OMGF_PRO_PLUGIN_FILE
		];

		return $licenses;
	}

	/**
	 * 
	 */
	public function is_advanced_processing_enabled()
	{
		return OMGF_PRO_ADVANCED_PROCESSING != 'on';
	}

	/**
	 * @param $options
	 *
	 * @return array
	 */
	public function add_show_notice_options($options)
	{
		$pro_options = [
			OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_FILE_TYPES,
			OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_FORCE_SUBSETS,
			OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_ADVANCED_PROCESSING,
			OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_STYLESHEETS,
			OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_INLINE_STYLES,
			OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_WEBFONT_LOADER,
			OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_EARLY_ACCESS,
			OmgfPro_Admin_Settings::OMGF_ADV_SETTING_SOURCE_URL
		];

		return array_merge($pro_options, $options);
	}
}

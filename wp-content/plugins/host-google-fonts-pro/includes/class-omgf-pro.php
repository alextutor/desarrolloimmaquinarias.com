<?php
defined('ABSPATH') || exit;

/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh
 * @license   BY-NC-ND-4.0
 *            http://creativecommons.org/licenses/by-nc-nd/4.0/
 */
class OmgfPro
{
	const OMGF_PRO_HANDLE_META_KEY                 = '_omgf_pro_handle';
	const OMGF_PRO_HANDLE_OPTION_NAME              = 'omgf_pro_home_handle';

	/** @var string $plugin_text_domain */
	private $plugin_text_domain = 'omgf-pro';

	/** @var string $init */
	private $init = true;

	/**
	 * Build class.
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Init hooks & filters.
	 */
	private function init()
	{
		$this->define_constants();
		$this->do_cron();

		if (version_compare(OMGF_PRO_STORED_DB_VERSION, OMGF_PRO_DB_VERSION) < 0) {
			$this->do_migrate_db();
		}

		add_filter('omgf_pro_advanced_processing_enabled', function () {
			return OMGF_PRO_ADVANCED_PROCESSING;
		});
		add_filter('omgf_include_file_types', function () {
			return OMGF_PRO_FILE_TYPES;
		});
		add_filter('content_url', [$this, 'rewrite_source_url']);

		/**
		 * @see OMGF_API_Download::grab_font_family
		 */
		if (OMGF_PRO_PROCESS_EARLY_ACCESS) {
			add_filter('omgf_alternate_fonts', [$this, 'add_early_access_fonts']);
			add_filter('omgf_alternate_api_url', [$this, 'add_early_access_api']);
		}

		if (is_admin()) {
			add_action('init', [$this, 'check_dependencies'], 1);
			add_action('init', [$this, 'init_admin'], 49);
			add_action('admin_notices', [$this, 'print_notices']);

			$this->add_ajax_hooks();
		}

		if (!is_admin()) {
			add_action('plugins_loaded', [$this, 'do_frontend_optimize'], 49);
			add_action('wp_enqueue_stylesheets', [$this, 'maybe_enqueue_merged_stylesheet']);
		}
	}

	/**
	 * Define constants.
	 */
	public function define_constants()
	{
		define('OMGF_PRO_STORED_DB_VERSION', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_PRO_DB_VERSION)));
		define('OMGF_PRO_OPTIMIZATION_MODE', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_MIGRATED_OPTIMIZE_SETTING_OPTIMIZATION_MODE, 'manual')));
		define('OMGF_PRO_CACHE_PATH', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_MIGRATED_ADV_SETTING_CACHE_PATH)) ?: '/uploads/omgf');
		define('OMGF_PRO_BATCH_SIZE', get_option(OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_BATCH_SIZE, '20'));
		define('OMGF_PRO_COMBINE_REQUESTS', 'on');
		define('OMGF_PRO_FILE_TYPES', get_option(OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_FILE_TYPES, ['woff2', 'woff']));
		define('OMGF_PRO_FORCE_SUBSETS', json_decode(get_option(OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_FORCE_SUBSETS, '')));
		define('OMGF_PRO_FALLBACK_FONT_STACK', get_option(OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_FALLBACK_FONT_STACK) ?: []);
		define('OMGF_PRO_ADVANCED_PROCESSING', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_ADVANCED_PROCESSING, 'on')));
		define('OMGF_PRO_SAFE_MODE', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_SAFE_MODE, '')));
		define('OMGF_PRO_PROCESS_STYLESHEETS', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_STYLESHEETS, 'on')));
		define('OMGF_PRO_PROCESS_STYLESHEET_IMPORTS', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_STYLESHEET_IMPORTS)));
		define('OMGF_PRO_PROCESS_STYLESHEET_FONT_FACES', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_STYLESHEET_FONT_FACES)));
		define('OMGF_PRO_PROCESS_INLINE_STYLES', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_INLINE_STYLES, 'on')));
		define('OMGF_PRO_PROCESS_WEBFONT_LOADER', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_WEBFONT_LOADER, 'on')));
		define('OMGF_PRO_PROCESS_EARLY_ACCESS', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_EARLY_ACCESS)));
		define('OMGF_PRO_PROCESS_RESOURCE_HINTS', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_DETECTION_SETTING_PROCESS_RESOURCE_HINTS, 'on')));
		define('OMGF_PRO_AMP_HANDLING', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_ADV_SETTING_AMP_HANDLING, 'disabled')));
		define('OMGF_PRO_EXCLUDED_IDS', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_ADV_SETTING_EXCLUDED_IDS)));
		define('OMGF_PRO_SOURCE_URL', esc_attr(get_option(OmgfPro_Admin_Settings::OMGF_ADV_SETTING_SOURCE_URL)) ?: content_url(OMGF_PRO_CACHE_PATH));
	}

	/**
	 * Handles all the cron related stuff for Automatic mode.
	 * 
	 * @return void 
	 */
	public function do_cron()
	{
		new OmgfPro_Cron();
	}

	/**
	 * Run any DB migration scripts if needed.
	 * 
	 * @return void 
	 */
	private function do_migrate_db()
	{
		new OmgfPro_DB_Migrate();
	}

	/**
	 * Rewrite Fonts Source URL if option is set.
	 * 
	 * @param mixed $url 
	 * @param mixed $path 
	 * @return mixed 
	 */
	public function rewrite_source_url($url)
	{
		// Make sure request is made by OMGF's API and we actually want to rewrite it.
		if (strpos($url, OMGF_PRO_CACHE_PATH) == false || OMGF_PRO_SOURCE_URL == false) {
			return $url;
		}

		/**
		 * We don't use content_url() here to prevent endless loops.
		 */
		return str_replace(WP_CONTENT_URL . OMGF_PRO_CACHE_PATH, OMGF_PRO_SOURCE_URL, $url);
	}

	/**
	 * Adds supported Early Access fonts as an alternate resource of fonts.
	 * 
	 * @return OmgfPro_EarlyAccessFonts 
	 */
	public function add_early_access_fonts()
	{
		return OmgfPro_EarlyAccessFonts::SUPPORTED_FONTS;
	}

	/**
	 * Add Early Access API to available stack of endpoints.
	 * 
	 * @return string 
	 */
	public function add_early_access_api()
	{
		$base_url = apply_filters('omgf_pro_eaf_api_base_url', OmgfPro_Admin::FFWP_BASE_URL);

		return $base_url . '/wp-json/omgf/v1/fonts/early-access?stylesheet=';
	}

	/**
	 * Initialize all Admin related tasks.
	 * 
	 * @return void 
	 */
	public function init_admin()
	{
		if (!$this->init) {
			return;
		}

		$this->do_settings();
		$this->do_admin();
	}

	/**
	 * Modify instructions for admin commands.
	 * 
	 * @return void 
	 */
	private function do_settings()
	{
		new OmgfPro_Admin_Settings();
	}

	/**
	 * Activates Pro options in OMGF's settings screen.
	 * 
	 * @return void 
	 */
	private function do_admin()
	{
		new OmgfPro_Admin();
	}

	/**
	 * Add notice to admin screen.
	 */
	public function print_notices()
	{
		OmgfPro_Admin_Notice::print_notice();
	}

	/**
	 * Modify behavior of OMGF's AJAX hooks.
	 * 
	 * @return void 
	 */
	private function add_ajax_hooks()
	{
		new OmgfPro_Ajax();
	}

	/**
	 * Run frontend Optimization logic.
	 */
	public function do_frontend_optimize()
	{
		new OmgfPro_Frontend_Optimize();
	}

	/**
	 * Helper to return WordPress filesystem subclass.
	 *
	 * @return WP_Filesystem_Base $wp_filesystem
	 */
	public static function filesystem()
	{
		global $wp_filesystem;

		if (is_null($wp_filesystem)) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		return $wp_filesystem;
	}

	/**
	 * OMGF Pro depends on License Manager and OMGF to function properly.
	 * 
	 * @since v3.0.1 Changed required_plugins to static array. Let's count on it that people don't rename the folder on purpose.
	 *
	 * @return bool
	 */
	public function check_dependencies()
	{
		$required_plugins = [
			'OMGF' => defined('OMGF_PLUGIN_FILE') ? OMGF_PLUGIN_FILE : false,
			'FFW.Press License Manager' => defined('FFWP_LICENSE_MANAGER_PLUGIN_FILE') ? FFWP_LICENSE_MANAGER_PLUGIN_FILE : false
		];

		$inactive_plugin = array_search(false, $required_plugins);

		if ($inactive_plugin) {
			$plugin_name = get_plugin_data(OMGF_PRO_PLUGIN_FILE)['Name'];

			// Clear all previously set notices.
			delete_transient(OmgfPro_Admin_Notice::OMGF_PRO_ADMIN_NOTICE_TRANSIENT);

			OmgfPro_Admin_Notice::set_pro_notice(sprintf(__('<strong>%s</strong> needs to be installed and active for %s to function properly. Please make sure it\'s installed and activated, before activating %s.', $this->plugin_text_domain), $inactive_plugin, $plugin_name, $inactive_plugin), 'error', 'omgf_pro_license_manager_not_active');

			deactivate_plugins(OMGF_PRO_PLUGIN_BASENAME);

			$this->init = false;

			return;
		}
	}
}

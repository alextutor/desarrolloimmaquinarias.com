<?php
defined('ABSPATH') || exit;

/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */
class OmgfPro_Admin_Settings
{
	/**
	 * Internal Use
	 */
	const OMGF_PRO_DB_VERSION = 'omgf_pro_db_version';

	/**
	 * Settings Page
	 */
	const OMGF_PRO_ADMIN_PAGE = 'optimize-webfonts';

	/**
	 * Settings Fields
	 */
	const OMGF_PRO_SETTINGS_FIELD_OPTIMIZE  = 'omgf-optimize-settings';
	const OMGF_PRO_SETTINGS_FIELD_DETECTION = 'omgf-detection-settings';
	const OMGF_PRO_SETTINGS_FIELD_ADVANCED  = 'omgf-advanced-settings';

	/**
	 * Optimize Fonts
	 */
	const OMGF_OPTIMIZE_SETTING_BATCH_SIZE          = 'omgf_pro_batch_size';
	const OMGF_OPTIMIZE_SETTING_FILE_TYPES          = 'omgf_pro_file_types';
	const OMGF_OPTIMIZE_SETTING_FORCE_SUBSETS       = 'omgf_pro_force_subsets';
	const OMGF_OPTIMIZE_SETTING_FALLBACK_FONT_STACK = 'omgf_pro_fallback_font_stack';

	/**
	 * Detection Settings
	 */
	const OMGF_DETECTION_SETTING_ADVANCED_PROCESSING           = 'omgf_pro_advanced_processing';
	const OMGF_DETECTION_SETTING_SAFE_MODE                     = 'omgf_pro_safe_mode';
	const OMGF_DETECTION_SETTING_PROCESS_RESOURCE_HINTS        = 'omgf_pro_process_resource_hints';
	const OMGF_DETECTION_SETTING_PROCESS_STYLESHEETS           = 'omgf_pro_process_stylesheets';
	const OMGF_DETECTION_SETTING_PROCESS_STYLESHEET_IMPORTS    = 'omgf_pro_process_stylesheet_imports';
	const OMGF_DETECTION_SETTING_PROCESS_STYLESHEET_FONT_FACES = 'omgf_pro_process_stylesheet_font_faces';
	const OMGF_DETECTION_SETTING_PROCESS_INLINE_STYLES         = 'omgf_pro_process_inline_styles';
	const OMGF_DETECTION_SETTING_PROCESS_WEBFONT_LOADER        = 'omgf_pro_process_webfont_loader';
	const OMGF_DETECTION_SETTING_PROCESS_EARLY_ACCESS          = 'omgf_pro_process_early_access';

	/**
	 * Advanced Settings
	 */
	const OMGF_ADV_SETTING_AMP_HANDLING = 'omgf_pro_amp_handling';
	const OMGF_ADV_SETTING_EXCLUDED_IDS = 'omgf_pro_excluded_ids';
	const OMGF_ADV_SETTING_SOURCE_URL   = 'omgf_pro_source_url';

	/**
	 * Migrated option from Free Version
	 */
	const OMGF_MIGRATED_OPTIMIZE_SETTING_OPTIMIZATION_MODE = 'omgf_optimization_mode';
	const OMGF_MIGRATED_ADV_SETTING_CACHE_PATH             = 'omgf_cache_path';

	/** @var string $active_tab */
	private $active_tab;

	/** @var string $page */
	private $page;

	/**
	 * OmgfPro_Admin_Settings constructor.
	 */
	public function __construct()
	{
		$this->active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'omgf-optimize-settings';
		$this->page       = isset($_GET['page']) ? $_GET['page'] : '';

		$this->init();
	}

	/**
	 * Initialize hooks
	 * 
	 * @return void 
	 */
	private function init()
	{
		/** Add logic for Automatic mode */
		add_action('update_option_omgf_optimization_mode', [$this, 'automatic_optimization_mode'], 10, 2);
		/** 
		 * Triggers almost immediately after admin_init action. 
		 * 
		 * @see https://codex.wordpress.org/Plugin_API/Action_Reference
		 * 
		 */
		add_action('current_screen', [$this, 'manual_optimization_mode']);
		add_filter('omgf_settings_constants', [$this, 'add_constants'], 10, 1);

		if (wp_doing_ajax()) {
			add_filter('omgf_clean_up_instructions', [$this, 'set_clean_up']);
		}
	}

	/**
	 * Add admin logic for Automatic optimization mode.
	 */
	public function automatic_optimization_mode($old_value, $value)
	{
		if ($value == 'auto') {
			new OmgfPro_Admin_Settings_OptimizationMode_Automatic();
		}

		return $value;
	}

	/**
	 * Add admin logic for Manual optimization mode.
	 */
	public function manual_optimization_mode()
	{
		if (OMGF_OPTIMIZATION_MODE == 'manual' && OMGF_PRO_ADVANCED_PROCESSING == 'on') {
			new OmgfPro_Admin_Settings_OptimizationMode_Manual();
		}
	}

	/**
	 * @param $constants
	 *
	 * @return array
	 * @throws ReflectionException
	 */
	public function add_constants($constants)
	{
		if (
			$this->active_tab !== self::OMGF_PRO_SETTINGS_FIELD_OPTIMIZE
			&& $this->active_tab !== self::OMGF_PRO_SETTINGS_FIELD_DETECTION
			&& $this->active_tab !== self::OMGF_PRO_SETTINGS_FIELD_ADVANCED
		) {
			return $constants;
		}

		$reflection = new ReflectionClass($this);
		$new_constants = $reflection->getConstants();

		return array_merge($new_constants, $constants);
	}

	/**
	 * Add Fallback Font Stacks to db clean up before emptying cache directory.
	 * 
	 * @since v2.5.0
	 *
	 * @param mixed $instructions 
	 * @return array containing a 'section', 'exclude' and 'queue'. 
	 */
	public function set_clean_up($instructions)
	{
		if ($this->active_tab !== self::OMGF_PRO_SETTINGS_FIELD_OPTIMIZE) {
			return $instructions;
		}

		$section = $instructions['section'] ?? '';

		if ($section == '/*') {
			array_push($instructions['queue'], self::OMGF_OPTIMIZE_SETTING_FALLBACK_FONT_STACK, OmgfPro_OptimizationMode_Automatic::QUEUE);
		}

		return $instructions;
	}
}

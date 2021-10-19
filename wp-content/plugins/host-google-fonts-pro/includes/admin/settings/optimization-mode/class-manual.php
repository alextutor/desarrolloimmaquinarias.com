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
class OmgfPro_Admin_Settings_OptimizationMode_Manual
{
    /** @var string $page */
    private $page = '';

    /** @var string $tab */
    private $tab = '';

    /** @var bool $settings_updated */
    private $settings_updated = false;

    /**
     * Build class.
     */
    public function __construct()
    {
        $this->page             = $_GET['page'] ?? '';
        $this->tab              = $_GET['tab']  ?? OmgfPro_Admin_Settings::OMGF_PRO_SETTINGS_FIELD_OPTIMIZE;
        $this->settings_updated = isset($_GET['settings-updated']);

        if ($this->page != OmgfPro_Admin_Settings::OMGF_PRO_ADMIN_PAGE) {
            return;
        }

        if ($this->tab != OmgfPro_Admin_Settings::OMGF_PRO_SETTINGS_FIELD_OPTIMIZE) {
            return;
        }

        if (!$this->settings_updated) {
            return;
        }

        $this->init();
    }

    /**
     * 
     */
    private function init()
    {
        $this->clear_jobs();

        new OmgfPro_OptimizationMode_Manual();
    }

    /**
     * Clear any left over Automatic cron jobs when plugin is in Manual mode.
     * 
     * @return void 
     */
    public function clear_jobs()
    {
        if (wp_next_scheduled(OmgfPro_Cron::HOOK)) {
            wp_clear_scheduled_hook(OmgfPro_Cron::HOOK);
        }
    }
}

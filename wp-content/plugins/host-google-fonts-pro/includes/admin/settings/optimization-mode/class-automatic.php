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
class OmgfPro_Admin_Settings_OptimizationMode_Automatic
{
    /** @var string $plugin_text_domain */
    private $plugin_text_domain = 'omgf-pro';

    /**
     * Build class.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * 
     */
    private function init()
    {
        $this->schedule_next_job();
        $this->show_notice();
    }

    /**
     * Schedules next job if Optimization Mode is set to Automatic. 
     * 
     * @return void 
     */
    public function schedule_next_job()
    {
        if (!wp_next_scheduled(OmgfPro_Cron::HOOK)) {
            wp_schedule_event(time(), OmgfPro_Cron::SCHEDULE, OmgfPro_Cron::HOOK);
        }
    }

    /**
     * We only have to show a message in admin, if optimization mode is set to Automatic.
     */
    private function show_notice()
    {
        OmgfPro_Admin_Notice::set_notice(
            __('OMGF Pro Automatic Optimization is silently running via cron schedule. You\'ll be notified of its progress through these notifications upon each page refresh.', $this->plugin_text_domain),
            'info',
            'omgf-pro-auto-running'
        );
    }
}

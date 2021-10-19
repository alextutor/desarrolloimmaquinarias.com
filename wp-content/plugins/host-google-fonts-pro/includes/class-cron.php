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

class OmgfPro_Cron
{
    const HOOK     = 'omgf_pro_automatic_optimization_mode';
    const SCHEDULE = 'two_minutes';

    /**
     * Build class.
     * 
     * @return void 
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Init filters and hooks.
     * 
     * @return void 
     */
    private function init()
    {
        add_filter('cron_schedules', [$this, 'add_custom_cron_interval'], 100);
        add_action(self::HOOK, [$this, 'run_automatic_mode']);
    }

    /**
     * Makes sure the Every Two Minutes cron schedule is available.
     * 
     * @param array $schedules 
     * @return array 
     */
    public function add_custom_cron_interval($schedules)
    {
        $schedules[self::SCHEDULE] = [
            'interval' => 120,
            'display'  => esc_html__('Every Two Minutes')
        ];

        return $schedules;
    }

    /**
     * This function is run when the scheduled event is triggered.
     * 
     * @return void 
     */
    public function run_automatic_mode()
    {
        new OmgfPro_OptimizationMode_Automatic();
    }
}

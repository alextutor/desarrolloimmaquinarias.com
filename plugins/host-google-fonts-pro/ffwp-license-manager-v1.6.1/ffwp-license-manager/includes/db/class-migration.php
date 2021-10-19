<?php

/**
 * @package   FFW.Press License Manager
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */

defined('ABSPATH') || exit;

class FFWPLM_DB_Migration
{
    /** @var string */
    private $current_version = '';

    /**
     * DB Migration constructor.
     */
    public function __construct()
    {
        $this->current_version = get_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_OPTION_DB_VERSION);

        if ($this->should_run_migration('1.4.0')) {
            new FFWPLM_DB_Migration_V140();
        }

        if ($this->should_run_migration('1.6.0')) {
            new FFWPLM_DB_Migration_V160();
        }
    }

    /**
     * Checks whether migration script has been run.
     * 
     * @param mixed $version 
     * @return bool 
     */
    private function should_run_migration($version)
    {
        return version_compare($this->current_version, $version) < 0;
    }
}

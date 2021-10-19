<?php
defined('ABSPATH') || exit;

/**
 * @package   FFW.Press License Manager
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */
class OmgfPro_DB_Migrate
{
    /** @var string */
    private $current_version = '';

    /**
     * DB Migration constructor.
     */
    public function __construct()
    {
        $this->current_version = get_option(OmgfPro_Admin_Settings::OMGF_PRO_DB_VERSION);

        if ($this->should_run_migration('2.4.0')) {
            new OmgfPro_DB_Migrate_V240();
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

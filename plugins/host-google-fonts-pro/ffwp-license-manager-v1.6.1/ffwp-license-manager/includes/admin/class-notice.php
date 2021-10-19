<?php

/**
 * @package   FFW.Press License Manager
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */

defined('ABSPATH') || exit;

class FFWPLM_Admin_Notice
{
    const FFWP_LICENSE_MANAGER_ADMIN_NOTICE_TRANSIENT = 'ffwp_license_manager_admin_notice';
    const FFWP_LICENSE_MANAGER_NOTICE_EXPIRATION      = 30;

    /** @var array $notices */
    public static $notices = [];

    /**
     * @param        $message
     * @param string $type (info|warning|error|success)
     * @param string $screen_id
     * @param bool   $json
     * @param int    $code
     */
    public static function set_notice($message, $die = true, $type = 'success', $code = 200, $screen_id = 'all')
    {
        self::$notices                      = get_transient(self::FFWP_LICENSE_MANAGER_ADMIN_NOTICE_TRANSIENT);
        self::$notices[$screen_id][$type][] = $message;

        set_transient(self::FFWP_LICENSE_MANAGER_ADMIN_NOTICE_TRANSIENT, self::$notices, self::FFWP_LICENSE_MANAGER_NOTICE_EXPIRATION);
    }

    /**
     * Prints notice (if any)
     */
    public static function print_notice()
    {
        $admin_notices = get_transient(self::FFWP_LICENSE_MANAGER_ADMIN_NOTICE_TRANSIENT);

        if (is_array($admin_notices)) {
            $current_screen = get_current_screen();

            foreach ($admin_notices as $screen => $notice) {
                if ($current_screen->id != $screen && $screen != 'all') {
                    continue;
                }

                foreach ($notice as $type => $message) {
?>
                    <div id="message" class="notice notice-<?php echo $type; ?> is-dismissible">
                        <?php foreach ($message as $line) : ?>
                            <p><?= $line; ?></p>
                        <?php endforeach; ?>
                    </div>
<?php
                }
            }
        }

        delete_transient(self::FFWP_LICENSE_MANAGER_ADMIN_NOTICE_TRANSIENT);
    }
}

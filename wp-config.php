<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'immaquinarias.com' );

/** MySQL database username */
define( 'DB_USER', 'alextuto_r' );

/** MySQL database password */
define( 'DB_PASSWORD', '0403221757' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '%/5W>?g~NMqy5Y=^>oLkuOVZ;d`w3b lUH/Kk!)]M`D~ltvUkL=2/Z.TmATf$vSp' );
define( 'SECURE_AUTH_KEY',  'I/@HI%[.C|^?Z~g;:D:a,Z8 51/Zlo_x|s:[`]3dK7T7.Z).DkpZQN1v$gtogt?@' );
define( 'LOGGED_IN_KEY',    ')59)ErodOS AyAB <j6xYOzh-O5wHm^/WnH,j6LEzR}xCkpMq[$3I5-Nb6R&bmV4' );
define( 'NONCE_KEY',        'jn}$D(U)GXwD7Q0d;7h{W~ =z 0xJ5.qzP4lIxMtb6h6IQ7%9S)7CPK!r$t7*iI`' );
define( 'AUTH_SALT',        'j*S>Ig2;SL%@;7;?:F<l^a365;,^HCU@XI#ORfa>bRlt+~|4*vZ}o}ztb1y:9Ul.' );
define( 'SECURE_AUTH_SALT', ',~((J*fw@!y|h_Kn9C7*zB7&AqP{rBB+xRiM=2pDv+9_C;n9w0bi8ZhrH@%8b7KY' );
define( 'LOGGED_IN_SALT',   'tfTaoF*F@<EM&msM,p%YDZ@V,qN)}2;/?l8dQL4KV9q7[wm9QguU@V}J+rq~k.eO' );
define( 'NONCE_SALT',       '=iDHd54Fz*t.x^R/!]<Ml Avin%kq3]JRG?~K[o)rjAq+vz,u[~0<NI:S?.K,yzs' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

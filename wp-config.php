<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'winnerswish_old' );

/** MySQL database username */
define( 'DB_USER', 'root123' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Zggj716$' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'LVonWkGpf=O+iFU.+%E2=,{]r*vWoHmy=E_%2o;f[]yTCGe}$rAExz2tQ<zL7CDq' );
define( 'SECURE_AUTH_KEY',  'e7S@bky@sq8$E-Ak/=m 9MaT03{mH.)9$H$Q$l6@I|@}~OLm]n};Wd6p_:.ZF}H!' );
define( 'LOGGED_IN_KEY',    'p_h^yI7xFsA629`%bs`(}e9D<)myRqs]NQ0:XGyY,3RI39VM.;EM!sVDGFZcKhXg' );
define( 'NONCE_KEY',        'yJkR11m T|S9;F2?P#1&N6^]XH;C]=hxpH+H7)IiZT1VW=+7F~b$.HWP{n(o[W7|' );
define( 'AUTH_SALT',        '@+&+C/)(6SeSq,Z-C--*j:zymwm<HO=(8z5Rw[>s#n.@iRSJ+G#?fe+EVV&GD&I-' );
define( 'SECURE_AUTH_SALT', 'tbr.taLGVWZ7piAn9WtkS]|*BH;/0O`bsM*YPUs[h%sn8EqX^eh5@F]cHCy_,q`z' );
define( 'LOGGED_IN_SALT',   'bj{]Ber9C^HbDc_le>]k>4drRAn12i^%;5,Ou][IXxzj|AoHW_w2N<7oe_vgTO|Y' );
define( 'NONCE_SALT',       'wFRA}?TJ6O+h%QF?>8c.Kw8?zpo2!QGG@Ci)?B )/WlE[}XlkKn?w|#` t$]u;x<' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'PQrlH_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

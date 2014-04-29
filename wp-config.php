<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'hotsale_hotsale');

/** MySQL database username */
define('DB_USER', 'hotsale_hotsale');

/** MySQL database password */
define('DB_PASSWORD', 'S12j3P603h');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'fftmheyaiuegn58xdsceneklgy5nphipzirldlcvtblnvhpeimpdikbsj2flctxi');
define('SECURE_AUTH_KEY',  '4bv8gn2cftmdkfdoyyo3cbqyc1kk1qbuz2urvtcjaswyyfaj7uc0plt7modydbkg');
define('LOGGED_IN_KEY',    'waafgkek4vwfx8bcg3dwe4meplfbh8peaau9p2nnfotquwcfug7pztudrtsh4san');
define('NONCE_KEY',        '8nbquw8imdspe0bscsb9y15rfydeqkhpsymujcdepyy0myaal3xorouyzwjaaynq');
define('AUTH_SALT',        'oqedgwrhgq2tphogb8qmefpuhwy6e8zyiktrbxcw8bisfymaorwsqgr6zthou1nj');
define('SECURE_AUTH_SALT', '5vq0m8zijqiozmddqwbgyio5imo4rr9io8zwbsindj6tqzapz0ymqy4ysdn8orlk');
define('LOGGED_IN_SALT',   'levtgjs0lhyhzixyliohtos5exxmfymwno3f8nedgbbqdbhhpma1l6bny0jfeurr');
define('NONCE_SALT',       'ytbmrj6hqpj7mqua2jpgch0ttkqmekk47wd1uy5m4xi5wckorol0yfonfgtcsacp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wpuser' );

/** Database password */
define( 'DB_PASSWORD', 'wppassword' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         'ZY2spj(Y ZqTYd}W]nNwc@mWQHsd#Zk~WB4,5as(e5AgBbrO)fE.m!XZ6RX~tN5O' );
define( 'SECURE_AUTH_KEY',  'tn(TH<!4lVs0j]Z]fT0S%{KukJwM2d~[Y<!NySihj550Pg:>nrp7ED uZ4=:i*$~' );
define( 'LOGGED_IN_KEY',    '5ImOXI{E;.$;^V6RJo7b=,I8w1!>Kg*~#M4cm2DFA=7H/L0R!!sq-+#vz,09rc!+' );
define( 'NONCE_KEY',        '9@o/ravsR5XE+DEuR>l`)v*4r6)Gj;j~0yRQ-!oc;95h;t$y|gr%4W%7u,>A1AfN' );
define( 'AUTH_SALT',        'c[$Td[jrZ#2oV}`J5],ijQiEBgnTXKm7f(D+EBf}nDb&CRPoxGFQml81VN^1yF|P' );
define( 'SECURE_AUTH_SALT', 'yu])I6m4E1l|5Eh,dRK<U89t}VgP:-0~t$!EF/x35alm!}1zX1,//L_fvjy7-vom' );
define( 'LOGGED_IN_SALT',   'D*1e*7)QqZ(5,dyaJ&`#gEGmHJCGz.Dsu[,lbx5:4cyD3 (|[iK8MbMd5:i`]Qxv' );
define( 'NONCE_SALT',       '3n](I8DYu6C.AR+O@DgZ$QsJOK_6f =>+jK1ZS;077ZWBEm84MC0^oM2M+*_rrY7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

/* Add any custom values between this line and the "stop editing" line. */
$env = parse_ini_file(__DIR__ . '/.env');


/* That's all, stop editing! Happy publishing. */
define('SA_DB_HOST', 'mysql');
define('SA_DB_NAME', 'auth_db');
define('SA_DB_USER', 'root');
define('SA_DB_PASS', 'rootpassword');
define('FS_METHOD', 'direct');
define('PASSKEY', $env['PASSKEY']);

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

// Tắt hiển thị lỗi Deprecated
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
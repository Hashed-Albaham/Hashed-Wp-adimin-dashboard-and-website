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
define( 'DB_NAME', 'lms' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', '0.0.0.0' );

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
define( 'AUTH_KEY',         'b.fN,qkdb)>6o<k!c3AMd?yqwUD*1*`D%u`FvM,}]i#SvRk,8g[Wnsj~W0qWF~`^' );
define( 'SECURE_AUTH_KEY',  'Q>7lb6%KqVIP(xhee@k4.GXI/3I<p=Cte_I^t|6*:{{H9Ubjbg)D&l#]uQFG5*h8' );
define( 'LOGGED_IN_KEY',    '8 DrLy7&-5tdt:D>>]oj-Bpd@:*Z1M&[mL8EX%?dfXTL<J.<%lj>~`lb@p/J3`; ' );
define( 'NONCE_KEY',        '[228BP[]Z74|!O R2cQuz!AB_-!H#z7Jdgu~^e^JigmJy{:@^gF_iO%9K5%`uhjB' );
define( 'AUTH_SALT',        'pD2R9E48a5TZs_mP>|{Ym{Wv0x.h g8lMDWvQ[Xe9h4l!4=S9NfoQM0m29CYradg' );
define( 'SECURE_AUTH_SALT', 'RaIvR/{faY,1R%*:Tiv!,{CALkRQ}.B!hYw=cS!^3QJiVyO( Mb5.TNd$W.GItmh' );
define( 'LOGGED_IN_SALT',   'D*AzD]x~1/@`-/`$KqEzO7[`;HI=.V8Yaqli*0?,5=2evS_A$/o@a^(&$H&Z_~| ' );
define( 'NONCE_SALT',       'V%=dDa]Rd]HTLE8&8ST35m$L9An^3C%bc,]0#]*LCW]>1{ !~w7Wu[6mR/-y7M*)' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'lms_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

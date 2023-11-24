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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'travel-blog_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'W$^&)yoTUV5n`5H7?Cr*?ai$xYGm(6nYD^k5AWZ&e58 wqxwME*$3,6[6H-hB&v*' );
define( 'SECURE_AUTH_KEY',  'tuFXo8)8t$,Sv`[uzqL>V=IxE;ac/.W,NIZ?I]vc2A@,:^{--2`c3wLXJY]~}84e' );
define( 'LOGGED_IN_KEY',    'Sedv Il$<h6hPqvK9LiQytPX4ML2+>]e%J+fi67!V/TYJE*4)iwF)93-cs8E7(,/' );
define( 'NONCE_KEY',        '{-)AkHzP[i9HjMv_qG{6*mQ&O _c>Bm<kApvM,yW|qY<Lk,V8@zE3z3*l92!At@K' );
define( 'AUTH_SALT',        '%Tb<=(Y,XP+S*__+6u(alf{Qr9&Z0{t[.~gn0,akc.NAwH!.WYRF5/:7/$i)-?ME' );
define( 'SECURE_AUTH_SALT', '|{5A2[Eo-sEN0>W?#XJo-xjp]hTgk`.2I.0eD0/-FU,b^;c;(z?]ne0,_Zb f.aD' );
define( 'LOGGED_IN_SALT',   'oJg=t%w1#[E^J!IxEXN!-MklP8jIsboz7RQNwIJPwq!4*C_/uhFUBafSW+t_}hWK' );
define( 'NONCE_SALT',       'kJU6 )6iJK2=&2Y(;?!x-1?mVHCbV;Qi0{If.{I*^JO3&VI<3)r/9&EK:X< ,Cp@' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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

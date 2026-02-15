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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'nITyhNl}$TL6_%4#XP:Haa]+fca_n!:7UnH^Fc)c^3jY1 !7< D MBP[sU4K;Z7.' );
define( 'SECURE_AUTH_KEY',   '/+<7NLH!Q[BLWSEOP`Xr+h_bZvbe)$Xh`}Oy3w ,t@[ST2H6hHk4tx7iRAiP;t5P' );
define( 'LOGGED_IN_KEY',     'KLdpzK~<oLmIHPM3ojwn7M6>w|qlZ([&&sjT!f9t#zycb3v|tHKttukd&?JGb[Vk' );
define( 'NONCE_KEY',         '}I2J  k[q#c{S<VP-1,Y0Ix#*H`#.WCXN9%JGpB$q1}0L],Uk%-aFtt<DP:F}IXO' );
define( 'AUTH_SALT',         'Q>k0VUK><XArsW38XvU+S*$?]uY{JN(#4Ch]{:jZd6l,xv=)agrLkYYtl+doXWp}' );
define( 'SECURE_AUTH_SALT',  '=^|WHZluWE3At18CKRCDARj^@q<#vy>aRK5]FB+*a)YJT|v8j9NoJ%adGK^+|fK#' );
define( 'LOGGED_IN_SALT',    'C3T#33.Mfg]GqY3/P]KxL`uyXm`vvH$6E?0#Yk_pt2{GtIfnMt#tSI(({Q*m ?Tk' );
define( 'NONCE_SALT',        'DQ`j8:k>{b(4>7QD!.5BE$eEK0Jvn}SzY$N+-/FB&3HiyzwiD*Y!M+1N)!Oos.2B' );
define( 'WP_CACHE_KEY_SALT', 'sYxsHl>!iErMkv|8(3sp8NY]/KLK[o`85}grF6>JZ{pS2d+z[glvwvhQ8D+Dk#IA' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

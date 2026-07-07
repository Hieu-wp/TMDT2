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
define( 'DB_NAME', 'tmdt_van' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define('WP_HOME', 'http://localhost/TMDT2');
define('WP_SITEURL', 'http://localhost/TMDT2');


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
define( 'AUTH_KEY',         '%A%UDvFg*B@E:tn-6V]<#Wdc??t.Q40C_#>%vVykejW~a/4;<&6s_f5{[+;Q-Q_=' );
define( 'SECURE_AUTH_KEY',  'zyi7{?.kVunm@FzM0uT>;%QJJ)uA/JpGGL/0>0a)M3a=L{.8SD*Lq.<ULGvC{`|3' );
define( 'LOGGED_IN_KEY',    '.:!UlftV3.q_7M,W7{Ky@O#|Q&J-9#@3<G<6(nRxgyIFW-M]dgx1k.<%6~e002/|' );
define( 'NONCE_KEY',        'i-s7#1y>5,Bv=Bzp=.hhZ:A_rIxk*V3eb0A)Y6pP@n[YJ%F=>:|8xCfh[YpHU^z5' );
define( 'AUTH_SALT',        '-Jq>ndz;.ll&LU3!De{07xN#kCK>9>=6@7u9E Mg~QN[09}<U!F8<}dqSO[XRM9z' );
define( 'SECURE_AUTH_SALT', 'O}M0u6(|3Y]X80! ll}%EFr?Yu)bd5.6VG&yS2M9v*|Y@a^S<E}ztzJEIRYr5&<r' );
define( 'LOGGED_IN_SALT',   '&SOqH%Q!4f%7dm>;H&IPN,0dHRe6v!)Gh,om8Ww|Id9aH<x-t8UNlfQ>=K` #Bc_' );
define( 'NONCE_SALT',       'RDyEJR=hN/Q9r;z*eKGx+V];XEB_aTp|A=y<55au]j[| M*w-m7]:d.OczKhM?$X' );
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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

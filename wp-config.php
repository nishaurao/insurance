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
define( 'DB_NAME', 'insurance' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '9,EG55!!yh}?Agux[;>m7*_SXNFe04ml/L}c7$oRRA.<hq54hFLrM]jj,@%IL>,g' );
define( 'SECURE_AUTH_KEY',  'aiGa1!Tf=!STX3e)Gx?Eo5Av4t1V^sPZxx&dRhZHP7gfNLDFd3Rw|:gmNWJ.(V6#' );
define( 'LOGGED_IN_KEY',    'x;TAyJg^FiemzTE{llr}eZgrbJ>%/.{uo&r=z1.Lzx1IV{g1a8p$=w{VnLo x*j/' );
define( 'NONCE_KEY',        '|i?NoHIm 2HE4##}riB)I(hqXD%+#LuU7krGM_8=<xfY*sgU8U#Y=FElo[-XXC#]' );
define( 'AUTH_SALT',        'utmC%g@1 `>}I))(#G;6{W2itEI%fPlim9N%<EiFmxDGM7opHr)6=CyXUQ{M2YLe' );
define( 'SECURE_AUTH_SALT', ')tjvcpFC)+jSDor5E_?L,J0E_DAT^kqtF}f!R9~q.6n[(mIQ@Wnjz&t9Wg!S{S4M' );
define( 'LOGGED_IN_SALT',   'Aw>%M(>@?Yy+&Kfqiz,HRu2a^xU+0EqB&DaHCO!rq?Hn/Aao2?Lkn~AvKB@{W RU' );
define( 'NONCE_SALT',       'uiiWGw`>sE4zA*iB(6T?p~t^g_1km>![Do<?&;[z<_m#CxUi?Z@rgs?ixt4?Kh47' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_insurance';

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

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
define( 'DB_NAME', 'test_tasks_etc' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'Q&#[6aj_/X@}@zlBr?neep5y^L^}1#K*o{u}k_>=s=t dR9k2RTDC-iQ)W`p$mdm' );
define( 'SECURE_AUTH_KEY',  'A6{o9n]^RcFS$ZlKu/gv(_{snQ+y:dL-^iKKqXFr.ZK:U1m<:T=@p.28O@sbOQIX' );
define( 'LOGGED_IN_KEY',    'T{r,&zCes77fwc{w^Rp)l<$79 &%uz=eP#]DWoWr*!It^-AD.vz* R>k4K}eqB<,' );
define( 'NONCE_KEY',        '*^t+k?b_-</7wpLR+&w!qx>q!j>tn{6G?oJ}AbPOud~28T;.[w1gc8Vm*N`l-Pn}' );
define( 'AUTH_SALT',        'Lbr-Gba@.vJ`R]o0G[ c3??H+pFYotJGdTb2(nJX4H7s3EdVX.(jE4S?QeE[?8W|' );
define( 'SECURE_AUTH_SALT', '~uQ%y_ID*-il)*)e(?.._+|V,T92og2tRVaIJp?sGC3_m^]Q<^/`Hm5V79+@WA [' );
define( 'LOGGED_IN_SALT',   'l/}M)hO55u TqmvO<zIYT&_-I?<Iq^i|(JYVsz=t<Az+JLG1v00Xt.A`IGn(G^G+' );
define( 'NONCE_SALT',       '-Wo? >,n.+*+Sdt nkAlP6MlbS:MiG(3BAXeI8D=7VQC-lX)wA#(>GjRmFoQP/6^' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

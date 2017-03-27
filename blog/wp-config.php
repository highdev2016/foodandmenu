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
define('DB_NAME', 'foodandm_foodandmenu');

/** MySQL database username */
define('DB_USER', 'foodandm_foodand');

/** MySQL database password */
define('DB_PASSWORD', '!/\/F()Dm!@');

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
define('AUTH_KEY',         'WE&&N(mKi -F}hVZ0`G;.JSv{c`$-,T=D~~TTH_!fydxqax-FNO#tDXGXn4o1N]q');
define('SECURE_AUTH_KEY',  'kpF2~c{,E4nuZNy|O=pO]y+!|e{SLoh&m$H+4rN-lo;uG*8:qOaEMUJ>nB0U[4qv');
define('LOGGED_IN_KEY',    'wGr]K`ZUS/S){UQb+|&JBXS|ok@P21l*ES-rX*K+-Xss)%+.TIoMxo$ii_~<=A-w');
define('NONCE_KEY',        '^Z>J8J1uhq_ca,uV&NEn/?T=4VBBQ+6>L[M!SmX]v8!}wW+4tVwQ,Ose:`|>$MR?');
define('AUTH_SALT',        'BhN3W]YHLHCv=NMi%Zl5W]2egE*k9N48E,|Z}MQcMXYr+Gxv/EaP|=j%9+KfdQ*,');
define('SECURE_AUTH_SALT', ',pC=KLqe1lq})_m;?O#.a~3SP+}dw@2ig2CV0u<8iE<W6Ce;-W0FUv{%?2`>XdN}');
define('LOGGED_IN_SALT',   '6L.lu9OG3X6.i<n_;T.SI|u!R,3<?-2MjO,1k6|^sFfNAj4F^GGtgV/$&J>Y5?t,');
define('NONCE_SALT',       'IjL/3Pv3(Nv]fcfABP&@j67P5iW~rWvwGtmQ#-gD0u-?l!Ih$j,iU^U]KNLRtf}?');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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

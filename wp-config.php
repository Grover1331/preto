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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'preto');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Incorrect0$');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'q! @K,@OW9{9W?-c+v4O@=6cJ4OX/;nT=s[4`4jU/L0yB:0DGel!dooa:QQ359mX');
define('SECURE_AUTH_KEY',  '_EDJqereh!%8OX@$+Xy.|nsG-!M1uOWXZY[ <<.ge!dc-=5Q)G`C>r&M*=R9-;kK');
define('LOGGED_IN_KEY',    '}X(=:j%8D45!}eb[Ttz/C~L^N%hhn/l<8dd6O2A>Zt<!CQ~#!EX`O=:K1.|oBZA&');
define('NONCE_KEY',        'cbprOlimS![uC9N`I@yM4]=@ISQ4sSjKr@[9<>!!Y]?~iKzL+~@G&;d%.NjG[GrV');
define('AUTH_SALT',        '%9R#TB?JXeb-TI(48%6S:7q;?V(ps$*-|%O4ytI!rBp+LV>?{GuNDMg)dNV(.fI*');
define('SECURE_AUTH_SALT', 'h(pbv34)E#G5qUc`rczTdyhG^oKb!I*P/ByLBp1R6ZkyODkK.v_cQy&r>oM5YT-X');
define('LOGGED_IN_SALT',   'd$=3K{&;T@d7ZALCP2TRxdoizC3_[3N~%[*CK$(O)i|l3ICVlZ:7G*@P26~*9JS(');
define('NONCE_SALT',       '6`B8Dyn+V+Vm3~u_4]}O[;3J>{tQG-GdhN9E|NGYDR{0JYYUMyA;CAnV|}7w3DeU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wtw_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

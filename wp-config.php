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
define('DB_NAME', 'ltcomms_wpdb');

/** MySQL database username */
define('DB_USER', 'ltcomms_wpusr');

/** MySQL database password */
define('DB_PASSWORD', 'nbmQ1VW+1AZdN');

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
define('AUTH_KEY',         ' vyUvxD.na>]*pXz<XG<M[_SP=CXlOfB=8!,HWW-C`6X+`[eW!4D~)IfZ-+u6%N)');
define('SECURE_AUTH_KEY',  'YBq4iEXv@YN6aHZo~A{E:SnCiDJM8h(uZGT?8.?am)&+*)tN} @e-MA38eycy GH');
define('LOGGED_IN_KEY',    'H4T4Y*~rI;JiCw?,#@MMa@6]?y~Arv^mnvMnh8VPKP5^c@8r({]yNmJ!;rZjC?_d');
define('NONCE_KEY',        '.d6cx!B^Qlew!NUnzi/(!L+!T3Qf)}GMbcSl6AZeo5R|>gzH2v2y%OGC5@czl6y`');
define('AUTH_SALT',        'N/V`Qnx7u&&?{4h:,<`Eb/4;YH-ibF{L5}A]AJqeDUl]:H251K{xilT&vE,9_sJY');
define('SECURE_AUTH_SALT', 'y1 c&*R#;^ w}?OG`X9Kr4!qbYhYLqF_]i(>^aY,^+G-~.(f%`pr=<%x-;x$MW*9');
define('LOGGED_IN_SALT',   's|/4f4zR^n@sp<Vm=!l7NfGzA1{/@@%4>!LMtAF_$pqw?C[[W9)I-uh_4qnwK2YN');
define('NONCE_SALT',       '3rCX%{rL]Da}HjH-MN{_JauwV6QTWGUKXRX;UPHYDV`h7;Zz8ghp&C?,VcWc5C/p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wptbl_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

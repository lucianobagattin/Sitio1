<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'sitio_1');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Ji?>zJ!wy4v%s;V@WMgUe)nARA!q= ?,y,3E?VoPE;+&GXG/%ODNrR`4UhwTdwo:');
define('SECURE_AUTH_KEY', 'b`T.+(GR_>I}SXWQRU<p1eXDCVI:o9G[S*hS;Dr>rFgYr,pcg<lLq!xD*/^e4qP[');
define('LOGGED_IN_KEY', '/9|]5nyHR9aJtzE2Q&al,Dv71{W?$PDL+]y?EK9*dHpF$4KyKo]/nl~-hL3ayvji');
define('NONCE_KEY', 'ck/m(E<2#:igj4V;{|%-DoYMJ^D:2!7y*J#v&[v]BA RTPCx]fJLq0(O H7C*QW!');
define('AUTH_SALT', 'G,=;4L%&eSd7vZe*sD|EEYbtXt<oX:Tsu^VZK *(VK=J3?10q|ywqLa,BI6P74Hj');
define('SECURE_AUTH_SALT', 'Xo=:]+#AqLb]1:~@sUOM,D.q_t>cfyG{asyV3R3zD9PRw~oSC<]8t@annx;d`boB');
define('LOGGED_IN_SALT', 'u]0r.QAr(3x>I6-`zN(9@lgo| S_iF!KIANVo@eT@N)F7CRbs`wnW=H~^/@u$| F');
define('NONCE_SALT', 'Lwy~5G2w:=[{pL1Ep/ghKi(MU%PR575>dwF,Zh&1}*N*~Fkhidzd=8^4T-p+mzzF');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


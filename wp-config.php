<?php
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungen gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es
 * auf der {@link http://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeugungsroutine verwendet. Sie wird ausgeführt,
 * wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von
 * wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

/**  MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster. */
/**  Ersetze database_name_here mit dem Namen der Datenbank, die du verwenden möchtest. */
define( 'DB_NAME', 'frontconference_db' );

/** Ersetze username_here mit deinem MySQL-Datenbank-Benutzernamen */
define( 'DB_USER', 'root' );

/** Ersetze password_here mit deinem MySQL-Passwort */
define( 'DB_PASSWORD', 'root' );

/** Ersetze localhost mit der MySQL-Serveradresse */
define( 'DB_HOST', 'localhost' );

/** Der Datenbankzeichensatz der beim Erstellen der Datenbanktabellen verwendet werden soll */
define( 'DB_CHARSET', 'utf8mb4' );

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden KEY in eine beliebige, möglichst einzigartige Phrase.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein. Du kannst die Schlüssel jederzeit wieder ändern,
 * alle angemeldeten Benutzer müssen sich danach erneut anmelden.
 *
 * @seit 2.6.0
 */
define( 'AUTH_KEY',         '+bB$`.ze8(X^ZFlp[F85l1MTZW?VZhu$8l=eg@E|W[( D_H@nTP0)/}y~eCK0xS+' );
define( 'SECURE_AUTH_KEY',  ' *pc&&M|JlqnNV}cs X{?GoW}[o=Gu.J42wm{:HOTG`;M3Y^z#ZL+[vaE5qvyrFx' );
define( 'LOGGED_IN_KEY',    'Z@4O!K1d]62KU#JuA5=hzgb&~>OHys=H~E>rP/pmq#7a0Wg%b]^f6xEo+5neJXjB' );
define( 'NONCE_KEY',        ',_[iAN+GsQdD-jX=+)Es?n21gv[cDqY>X[5_QZEF`0./Y!K3.Gy8;;D*g%}B)uq7' );
define( 'AUTH_SALT',        '1u4[ZK2nwAC$!%U>?4sf)`vmacR@Og;kMuHzdOC7E>qckNV^Amr6F%VgPOR(yX]m' );
define( 'SECURE_AUTH_SALT', 'v?LTwPl%?@(-S|v$3z-USXH~zwu8wz+WsbrUlmW8eH6CLJ_Kk_)0Uo{. >+x(w35' );
define( 'LOGGED_IN_SALT',   'BHHS#|;4E_z7j]YH@^EsFECYFAFoBe6bbCRz0X7jE_Q,Q^r^Um^RZ!T9&6_$(y6 ' );
define( 'NONCE_SALT',       'A;Ok.1StVp&-Pqz-s2F}Ky=w2=V75_wpLlB,Za$(4r#%^[_n|}>-PXv}C!*tpBfH' );

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix  = 'wp_';

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

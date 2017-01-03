<?php

// $Id: config.inc.php 1336 2010-04-21 09:53:39Z jberanek $

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file
 *   (except for the lang.* files, eg lang.en for English, if
 *   you want to change text strings such as "Meeting Room
 *   Booking System", "room" and "area").
 **************************************************************************/

// The timezone your meeting rooms run in. It is especially important
// to set this if you're using PHP 5 on Linux. In this configuration
// if you don't, meetings in a different DST than you are currently
// in are offset by the DST offset incorrectly.
//
// When upgrading an existing installation, this should be set to the
// timezone the web server runs in.
//
$timezone = "America/Argentina/San_Luis";


/*******************
 * Database settings
 ******************/

 // CONFIGURACION DEL PLANNING DE PRODUCCION
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL,
// "mysqli"=MySQL via the mysqli PHP extension
$dbsys = "mysql";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP.
$db_host = "localhost";
// Database name:
$db_database = "planningdb";
// Database login user name:
$db_login = "root";
// Database login password:
$db_password = '';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "plan_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
// $db_nopersist = 1;

/*
//CONFIGURACION DEL PLANNING DE PRUEBAS
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL,
// "mysqli"=MySQL via the mysqli PHP extension
$dbsys = "mysql";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP.
$db_host = "localhost";
// Database name:
$db_database = "planningdb_qa";
// Database login user name:
$db_login = "Planning_QAUser";
// Database login password:
$db_password = 'UAplanning.125';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "plan_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
// $db_nopersist = 1;
*/

/* Add lines from systemdefaults.inc.php here to change the default
   configuration. Do _NOT_ modify systemdefaults.inc.php. */

$mrbs_company = "Universidad Austral";
$mrbs_company_logo = "logoaustral4.png";
$mrbs_company_url = "http://www.austral.edu.ar/";
$url_base = "http://planning.austral.edu.ar";

$mrbs_admin = "Mariano Leguizamon";
$mrbs_admin_email = "mleguizamon@austral.edu.ar"; 

//$auth["session"] = "http";
//$auth["type"] = "ldap";

//$ldap_host = "10.0.10.12";
//$ldap_port = 389;
// If you do not want to use LDAP v3, change the following to false
//$ldap_v3 = false;
// If you want to use TLS, change the following to true
//$ldap_tls = false;
// LDAP base distinguish name
// See AUTHENTICATION for details of how check against multiple base dn's
//$ldap_base_dn = "dc=austral,dc=edu,dc=ar";
//$ldap_user_attrib = "uid";
// "username". In Microsoft AD directories this is "sAMAccountName";
//$ldap_dn_search_attrib = "sAMAccountName";
//$ldap_dn_search_dn = "cn=Soporte,ou=TyS,ou=Cuentas genéricas,ou=Users,ou=Garay,dc=austral,dc=edu,dc=ar ";
//$ldap_dn_search_password = "tysuasto";
//$Ldap_debug = TRUE;
//$ldap_filter

$mail_settings['admin_on_bookings']         = TRUE;  // the addresses defined by $mail_settings['recipients'] below
$mail_settings['area_admin_on_bookings']    = TRUE;  // the area administrator
$mail_settings['room_admin_on_bookings']    = TRUE;  // the room administrator
$mail_settings['booker'] = TRUE;  // the person making the booking
$mail_settings['book_admin_on_provisional'] = TRUE;  // the booking administrator when provisional bookings are enabled

$mail_settings['admin_on_delete'] = TRUE;  // when an entry is deleted
$mail_settings['admin_all']       = TRUE;  // edits as well as new bookings
$mail_settings['details'] = TRUE;  // Set to TRUE if you want full booking details;


$smtp_settings['host'] = 'relay.austral.edu.ar';  // SMTP server
$smtp_settings['port'] = 25;           // SMTP port number
$smtp_settings['auth'] = FALSE;        // Whether to use SMTP authentication
$smtp_settings['username'] = 'planning@austral.edu.ar';       // Username (if using authentication)
$smtp_settings['password'] = 's3d3garay';       // Password (if using authentication)
$mail_settings['admin_lang'] = 'es';   // Default is 'en'.

$mail_settings['domain'] = '@austral.edu.ar';

$mail_settings['admin_backend'] = 'smtp';

$mail_settings['from'] = 'planning@austral.edu.ar';

// Set the recipient email. Default is 'admin_email@your.org'. You can define
// more than one recipient like this "john@doe.com,scott@tiger.com"
$mail_settings['recipients'] = 'mleguizamon@austral.edu.ar,allopez@austral.edu.ar';

// Set email address of the Carbon Copy field. Default is ''. You can define
// more than one recipient (see 'recipients')
// $mail_settings['cc'] = '';

// Set to TRUE if you want the cc addresses to be appended to the to line.
// (Some email servers are configured not to send emails if the cc or bcc
// fields are set)
$mail_settings['treat_cc_as_to'] = FALSE;



// This next section must come at the end of the config file - ie after any
// language and mail settings, as the definitions are used in the included file
require_once "language.inc";   // DO NOT DELETE THIS LINE

/*************
 * Entry Types
 *************/

// This array maps entry type codes (letters A through J) into descriptions.
//
// Each type has a color which is defined in the array $color_types in the Themes
// directory - just edit whichever include file corresponds to the theme you
// have chosen in the config settings. (The default is default.inc, unsurprisingly!)
//
// The value for each type is a short (one word is best) description of the
// type. The values must be escaped for HTML output ("R&amp;D").
// Please leave I and E alone for compatibility.
// If a type's entry is unset or empty, that type is not defined; it will not
// be shown in the day view color-key, and not offered in the type selector
// for new or edited entries.

$typel["A"] = get_vocab("fce");
$typel["B"] = get_vocab("fcb");
$typel["C"] = get_vocab("fc");
$typel["D"] = get_vocab("fd");
$typel["E"] = get_vocab("ee");
$typel["F"] = get_vocab("icf");
$typel["G"] = get_vocab("if");
$typel["H"] = get_vocab("rec");
$typel["I"] = get_vocab("fi");
$typel["J"] = get_vocab("otros");
$typel["K"] = get_vocab("fer");
$typel["L"] = get_vocab("enf");
$typel["M"] = get_vocab("tys");
$typel["N"] = get_vocab("psicologia");
#$typel["O"] = get_vocab("fipigm");
$typel["P"] = get_vocab("admisiones");
$typel["Q"] = get_vocab("iae");
$typel["R"] = get_vocab("im");
$typel["S"] = get_vocab("ri");
$typel["T"] = get_vocab("oei");
$typel["U"] = get_vocab("sede");
#$typel["V"] = get_vocab("fcpci");
#$typel["W"] = get_vocab("fdmde");
#$typel["X"] = get_vocab("fdedt");
#$typel["Y"] = get_vocab("fdmmj");
#$typel["Z"] = get_vocab("fdmda");

?>

<?php
	
    /*
     * APPLICATION-RELATED CONFIGURATION FILE.
     */

	defined('WWW') or die('Forbidden.');
	
	/* --- GENERAL --- */
	define('APP_PRODUCTION', 0);
	define('DEFAULT_CONTROLLER', '');
	
	/* --- DATABASE --- */
	define('DB_HOST', '');
	define('DB_NAME', '');
	define('DB_USER', '');
	define('DB_PASSWORD', '');
	
	/* --- LANGUAGES --- */
	define('MULTILANGUAGE', 0); // 0 - Disabled. 1 - Enabled.
	define('DEFAULT_LANGUAGE', 'en'); // Short code (examples: 'en', 'fr', 'de', 'es',...).
	define('LANGUAGE_DEFINED_BY', 'URI'); // 'URI' (example: example.com/fr/) or 'SUBDOMAIN' (example: fr.example.com).
	define('LOCALE_FILE', 'texts'); // Name of the PO/MO file.
	
	/* Uncomment to set your app's languages.
	$languages = array(
		'es' => 'es_ES',
		'en' => 'en_UK',
		'fr' => 'fr_FR'
	);
	*/
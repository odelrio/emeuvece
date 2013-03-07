<?php
	
    /*
     * FRAMEWORK-RELATED CONFIGURATION FILE.
     */

	defined('WWW') or die('Forbidden.');

	define('DS', DIRECTORY_SEPARATOR);
	define('CORE_PATH', __DIR__);
	define('APP_PATH', str_replace(DS . basename(__DIR__), '', __DIR__) . DS . 'app');
	define('CORE_CLASSES_DIR', CORE_PATH . DS . 'classes');
	define('TEMPLATE_SYSTEM_DIR', CORE_PATH . DS . 'tplsys');
	define('CONTROLLERS_DIR', APP_PATH . DS . 'controllers');
	define('MODELS_DIR', APP_PATH . DS . 'models');
	define('VIEWS_DIR', APP_PATH . DS . 'views');
	define('TEMPLATES_DIR', APP_PATH . DS . 'templates');
	define('LOCALE_DIR', APP_PATH . DS . 'locale');
	define('CLASSES_DIR', APP_PATH . DS . 'classes');
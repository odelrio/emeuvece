<?php

	defined('WWW') or die('Forbidden.');
	
	/**
	 * Framework main class.
	 * @method load(string $file1 [, string $...]) Requires one or
	 * more files if they exist.
	 */
	class Core {
	    
		private static $_languages = array();
		
		public static function __callStatic($method, $args) {
			
			switch ($method) {
				
				case 'load':
					
					if (!count($args)) return false;
					else return self::loadFiles($args);
					
					break;
				
			}
			
		}
		
		/**
		 * If a file exists, requires it.
		 * @param string Path to the file with or without PHP extension.
		 * @return boolean Success.
		 */
		private static function loadFile($path) {

			if (!file_exists($path)) $path .= '.php';
			if (!file_exists($path)) return false;
			require_once $path;
			return true;
			
		}
		
		/**
		 * Requires all files within an array, checking that they exist.
		 * @param type Array of file paths.
		 * @return boolean Success.
		 */
		private static function loadFiles($files) {
			
			foreach ($files as $path)
				if (!self::loadFile($path)) return false;
			
			return true;
			
		}
		
		/**
		 * Requires a controller/view/model class and returns an object with it.
		 * @param string File path.
		 * @param string Class name (without suffix).
		 * @param string Class' suffix ('Controller', 'View' or 'Model'). 
		 * @param array Construct's arguments.
		 * @return boolean Success.
		 */
		private static function create($path, $name, $type, $args = array()) {
			
			if (!self::loadFile($path)) return false;
			$class = new ReflectionClass(ucfirst($name) . $type);
			
			if (count($args) && !empty($args[0])) return $class->newInstanceArgs($args);
			else return $class->newInstanceArgs();
			
		}
		
		/**
		 * Returns a view.
		 * @param string Name of the view, lowercase and without
		 * <em>-View</em> suffix.
		 * @return object View object or FALSE.
		 */
		public static function loadView($name) {
			
			return self::create(VIEWS_DIR . DS . strtolower($name) . '.php', $name, 'View');
			
		}
		
		/**
		 * Returns a controller.
		 * @param string Name of the controller, lowercase and without
		 * <em>-Controller</em> suffix.
		 * @return object Controller object or FALSE.
		 */
		public static function loadController($name) {
			
			return self::create(CONTROLLERS_DIR. DS . strtolower($name) . '.php', $name, 'Controller');
			
		}
		
		/**
		 * Returns a model.
		 * @param string Name of the model, lowercase and without
		 * <em>-Model</em> suffix.
		 * @return object Model object or FALSE.
		 */
		public static function loadModel($name) {
			
			return self::create(MODELS_DIR. DS . strtolower($name) . '.php', $name, 'Model');
			
		}
		
		/**
		 * Processes configuration files.
		 */
		public static function loadConfig() {
			
			require '..' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'config.php'; // Framework config.
			require APP_PATH . DS . 'config.php'; // Application config.
			
			ini_set('display_errors', 'off');
			error_reporting(0);

			// Show errors in development mode.
			if (!APP_PRODUCTION) {

				ini_set('display_errors', 'on');
				error_reporting(E_ALL);

			}
			
			$protocol = 'http';
			if (!empty($_SERVER['HTTPS'])) $protocol .= 's'; // Set HTTPS as protocol.
			$url = $protocol . '://' . $_SERVER['SERVER_NAME'];
			$resources = $url;
			$request = $_SERVER['REQUEST_URI'];
			
			if (MULTILANGUAGE) {
				
				self::$_languages = $languages;
				unset($languages);
				
				$language = DEFAULT_LANGUAGE;
	
				switch(strtoupper(LANGUAGE_DEFINED_BY)) {

					case 'URI':

						$matches = array();
						preg_match('/^\/\w+\/?/', $_SERVER['REQUEST_URI'], $matches);

						if (count($matches) && self::languageExists(trim($matches[0], '/'))) { // Language detected in URI.

							$language = trim($matches[0], '/');
							$url .= '/' . $language; // Add language to the URL.
							$request = preg_replace('/^\/\w+/', '', $request); // Omit the language in request.
							if (!$request) $request = '/';

						}

						break;

					case 'SUBDOMAIN':

						$matches = array();
						preg_match('/^\w+\./', $_SERVER['SERVER_NAME'], $matches);
						
						if (count($matches) && self::languageExists(trim($matches[0], '.'))) {
							
							$language = trim($matches[0], '.');
							
						}
						
						break;

					case 'COOKIE':

						// Not yet.
						break;

				}

				self::setLanguage($language);

				define('LANGUAGE', $language);
				unset($language);
				
			}
			
			define('PROTOCOL', $protocol);
			define('URL', $url);
			define('RESOURCES', $resources);
			define('REQUEST', $request);
			unset($protocol, $url, $resources, $request);
			
		}
		
		/**
		 * Loads the templating system.
		 */
		public static function loadTemplatingSystem() {
			
			require TEMPLATE_SYSTEM_DIR . DS . 'Haanga.php';
	
			Haanga::configure(array(
				'template_dir' => TEMPLATES_DIR,
				'cache_dir' => TEMPLATES_DIR . DS . 'cache'
			));
			
		}
		
		/**
		 * Loads the framework classes.
		 */
		public static function loadComponents() {
			
			require CORE_CLASSES_DIR . DS . 'class.controller.php';
			require CORE_CLASSES_DIR . DS . 'class.view.php';
			require CORE_CLASSES_DIR . DS . 'class.database.php';
			require CORE_CLASSES_DIR . DS . 'class.model.php';
			
		}
		
		/**
		 * Processes the request.
		 */
		public static function router() {
			
			if (REQUEST != '/') { 
		
				$uri = explode('/', trim(REQUEST, '/'));
				$controller = Core::loadController($uri[0]);

				if ($controller) {

					if (isset($uri[1])) {

						$method = $uri[1];

						if (method_exists($controller, $method)) {

							if (count($uri) > 2) { // Call with methods.

								$args = array_slice($uri, 2); // Grab the parameters.
								call_user_func_array(array($controller, $method), $args);

							} else $controller->$method(); // Call without methods.

						} else self::displayError('no ' . $method . ' method found in ' . $uri[0] . ' controller.');

					} else {

						if (method_exists($controller, 'index')) $controller->index();
						else self::displayError('no index method found in ' . $uri[0] . ' controller.');

					}

				} else self::displayError('no ' . $uri[0] . ' controller found.');

			} else { // Root.

				$controller = Core::loadController(DEFAULT_CONTROLLER);

				if ($controller) {

					if (method_exists($controller, 'index')) $controller->index();
					else self::displayError('no index method found in the default controller.');

				} else self::displayError('unable to load the default controller. Please verify the configuration file.');

			}
			
		}
		
		/**
		 * Sets up the Gettext environment.
		 * @param string Language short-code, as defined in 
		 * <b>app/config.php</b>.
		 * @return boolean Success.
		 */
		private static function setLanguage($lang) {
			
			if (!self::languageExists($lang)) return false;
			
			putenv('LANGUAGE=' . self::$_languages[$lang]);
			putenv('LANG=' . self::$_languages[$lang]);
			if (!defined('LC_MESSAGES')) define('LC_MESSAGES', 5);
			setlocale(LC_MESSAGES, self::$_languages[$lang]);
			bindtextdomain(LOCALE_FILE, LOCALE_DIR);
			textdomain(LOCALE_FILE);
			bind_textdomain_codeset(LOCALE_FILE, 'UTF-8');
			
			return true;
			
		}
		
		/**
		 * Checks if there is such language in <b>app/config.php</b>
		 * @param string $lang
		 * @return boolean Exists.
		 */
		private static function languageExists($lang) {
			
			return array_key_exists($lang, self::$_languages);
			
		}
		
		public static function displayError($msg, $die = true) {
			
			echo "hola";
			
			if (!APP_PRODUCTION) {
				
				echo "<br /><b>Error</b>: $msg<br />";
				
			}
			
			if ($die) die();
			
		}

	}

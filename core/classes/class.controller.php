<?php
	
	defined('WWW') or die('Forbidden.');
	
	/**
	 * Defines what a controller can do.
	 */
	abstract class Controller {

		/**
		 * Returns a model object.
		 * @param string Model name, lowercase and without the suffix.
		 * @return object
		 */
		protected function model($name) {

			return Core::loadModel($name);

		}

		/**
		 * Returns a model object.
		 * @param string Model name, lowercase and without the suffix.
		 * @return object
		 */
		protected function view($name) {

			return Core::loadView($name);
			
		}
		
		/**
		 * Redirects to an URL.
		 * @param string Absolute or relative URL.
		 */
		protected function go($url) {
			
			header('Location: ' . $url);
			
		}

	}

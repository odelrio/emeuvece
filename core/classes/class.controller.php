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
		protected function model($name, $data = null) {

			return Core::loadModel($name, $data);

		}

		/**
		 * Returns a model object.
		 * @param string Model name, lowercase and without the suffix.
		 * @return object
		 */
		protected function view($name, $data = null) {

			return Core::loadView($name, $data);
			
		}
		
		/**
		 * Redirects to an URL.
		 * @param string Absolute or relative URL.
		 */
		protected function go($url) {
			
			header('Location: ' . $url);
			
		}

	}

<?php
	
	defined('WWW') or die('Forbidden.');
	
	/**
	 * Defines what a controller can do.
	 */
	abstract class Controller {

		/**
		 * Calls a model.
		 * @param string Model name, lowercase and without the suffix.
		 * @param string Method name (optional).
		 * @param array Ordered array with method arguments (optional).
		 * @return boolean Success.
		 */
		protected function model($name, $method = null, $data = array()) {

			$model = Core::loadModel($name);
			
			if (!$model) {
				
				Core::displayError("$name view does not exist.");
				return false;
				
			}
			
			if (method_exists($model, $method)) {
				
				call_user_func_array(array($model, $method), $data);
				
			} elseif (method_exists($model, "index")) {
				
				$model->index($data);
				
			} else return false;
			
			return true;

		}

		/**
		 * Calls a view.
		 * @param string View name, lowercase and without the suffix.
		 * @param string Method name (optional).
		 * @param array Ordered array with method arguments (optional).
		 * @return boolean Success.
		 */
		protected function view($name, $method = null, $data = array()) {

			$view = Core::loadView($name);
			
			if (!$view) {
				
				Core::displayError("$name view does not exist.");
				return false;
				
			}
			
			if (method_exists($view, $method)) {
				
				call_user_func_array(array($view, $method), $data);
				
			} elseif (method_exists($view, "index")) {
				
				$view->index($data);
				
			} else return false;
			
			return true;
			
		}
		
		/**
		 * Redirects to an URL.
		 * @param string Absolute or relative URL.
		 */
		protected function go($url) {
			
			header('Location: ' . $url);
			
		}

	}

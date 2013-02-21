<?php

	defined('WWW') or die('Forbidden.');
	
	/**
	 * Defines what a view can do.
	 * @property string $html Construct the HTML code here.
	 */
	abstract class View {
		
		protected $html;
		
		/**
		 * Returns a HTML template.
		 * @param string Template file name or path relative to TEMPLATES_DIR.
		 * @param array Data to fill the blanks.
		 * @return string HTML code. You may want to pipe it to $html property.
		 */
		protected function template($template_file, $data) {
			
			return Haanga::Load($template_file, $data, true);
			
		}
		
		/**
		 * Prints the HTML stored in the $html property.
		 */
		protected function render() {
			
			echo $this->html;
			
		}
		
	}

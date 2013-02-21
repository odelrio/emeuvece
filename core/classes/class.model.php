<?php

	defined("WWW") or die("Forbidden.");
	
	/**
	 * Defines what a model can do.
	 */
	abstract class Model {
		
		protected $db;
		
		public function __construct() {
			
			$this->db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
			$this->db->open();
			
		}
		
		public function __destruct() {
			
			$this->db = null;
			unset($this->db);
			
		}
		
	}


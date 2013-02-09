<?php

	defined("WWW") or die("Forbidden.");
	
	/**
	 * Defines how to establish a connection with a DB.
	 */
	class Database extends PDO {
		
		private $db_host, $db_name, $db_user, $db_pass;
		
		function __construct($host = DB_HOST, $name = DB_NAME, $user = DB_USER, $pass = DB_PASSWORD) {
			
			$this->db_host = $host;
			$this->db_name = $name;
			$this->db_user = $user;
			$this->db_pass = $pass;
				
		}
		
		public function open() {
		
			try {

				parent::__construct("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (PDOException $e) {

				throw $e;
				return false;

			}
			
		}
		
	}
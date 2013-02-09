<?php

	defined('WWW') or die('Forbidden.');
	
	session_start();
	
	Core::loadConfig();
	Core::loadTemplatingSystem();
	Core::loadComponents();	
	Core::router();
<?php

	/**
	 * Stops the execution and displays passed data.
	 * @param mixed Any object, variable, function result or expression.
	 */
	function dbg($x) {

		ob_start();
		var_dump($x);
		$result = ob_get_clean();
		die("<code><pre>$result</pre></code>");
		
	}
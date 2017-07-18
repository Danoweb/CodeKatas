<?php
/**
 * @version V5.17 17 May 2012   (c) 2000-2012 John Lim (jlim#natsoft.com). All rights reserved.
 * Released under both BSD license and Lesser GPL library license.
 * Whenever there is any discrepancy between the two licenses,
 * the BSD license will take precedence.
 *
 * Set tabs to 4 for best viewing.
 *
 * Latest version is available at http://php.weblogs.com
 *
*/

// added Claudio Bustos  clbustos#entelchile.net
if (!defined('ADODB_ERROR_HANDLER_TYPE')) define('ADODB_ERROR_HANDLER_TYPE',E_USER_ERROR); 

if (!defined('ADODB_ERROR_HANDLER')) define('ADODB_ERROR_HANDLER','ADODB_Error_Handler');

/**
* Default Error Handler. This will be called with the following params
*
* @param $dbms		the RDBMS you are connecting to
* @param $fn		the name of the calling function (in uppercase)
* @param $errno		the native error number from the database
* @param $errmsg	the native error msg from the database
* @param $p1		$fn specific parameter - see below
* @param $p2		$fn specific parameter - see below
* @param $thisConn	$current connection object - can be false if no connection object created
*/
function ADODB_Error_Handler($dbms, $fn, $errno, $errmsg, $p1, $p2, &$thisConnection)
{
	//if (error_reporting() == 0) return; // obey @ protocol
	switch($fn) 
	{
		case 'EXECUTE':
			$sql = $p1;
			$inputparams = $p2;
	
			$s = "$dbms error: [$errno: $errmsg] in $fn(\"$sql\")\n";
			
			$subject = "ADODB Error on " . $_SERVER['HTTP_HOST'];
			
			$message = "<html><body>";
			
			//BUILD EMAIL ERROR MESSAGE
			$message .= "<strong>ADODB Error on " . $_SERVER['HTTP_HOST'] . ' in ' . $_SERVER['REQUEST_URI'] . "</strong><br />";
			$message .= "<strong>Error was: </strong> " . $s . "<br />";
			$message .= "<strong>Error occured at: </strong> " . date('Y-m-d H:i:s');
			
			//SESSION VARS
			$message .= '<table border="1" cellspacing="2" cellpadding="0" style="width: 100%; background-color: #CCCCCC;">';
			$message .= '<tr><th colspan="2">SESSION VARS:</th></tr>';
			foreach($_SESSION as $key => $val) 
			{
				$message .= '<tr>';
				$message .= '<th>' . $key . '</th><td>' . htmlentities($val) . '</td>';
				$message .= '</tr>';
			}//END FOREACH SESSION
			$message .= '</table>';
			
			//REQUEST VARS
			$message .= '<table border="1" cellspacing="2" cellpadding="0" style="width: 100%; background-color: #CCCCCC;">';
			$message .= '<tr><th colspan="2">REQUEST VARS:</th></tr>';
			foreach($_REQUEST as $key => $val) 
			{
				$message .= '<tr>';
				$message .= '<th>' . $key . '</th><td>' . htmlentities($val) . '</td>';
				$message .= '</tr>';
			}//END FOREACH REQUEST
			$message .= '</table>';
			
			//POST VARS
			$message .= '<table border="1" cellspacing="2" cellpadding="0" style="width: 100%; background-color: #CCCCCC;">';
			$message .= '<tr><th colspan="2">POST VARS:</th></tr>';
			foreach($_POST as $key => $val) 
			{
				$message .= '<tr>';
				$message .= '<th>' . $key . '</th><td>' . htmlentities($val) . '</td>';
				$message .= '</tr>';
			}//END FOREACH POST
			$message .= '</table>';
			
			//COOKIE VARS
			$message .= '<table border="1" cellspacing="2" cellpadding="0" style="width: 100%; background-color: #CCCCCC;">';
			$message .= '<tr><th colspan="2">COOKIE VARS:</th></tr>';
			foreach($_COOKIE as $key => $val) 
			{
				$message .= '<tr>';
				$message .= '<th>' . $key . '</th><td>' . htmlentities($val) . '</td>';
				$message .= '</tr>';
			}//END FOREACH COOKIE
			$message .= '</table>';
			
			//SERVER VARS
			$message .= '<table border="1" cellspacing="2" cellpadding="0" style="width: 100%; background-color: #CCCCCC;">';
			$message .= '<tr><th colspan="2">SERVER VARS:</th></tr>';
			foreach($_SERVER as $key => $val) 
			{
				$message .= '<tr>';
				$message .= '<th>' . $key . '</th><td>' . htmlentities(print_r($val, true)) . '</td>';
				$message .= '</tr>';
			}//END FOREACH SERVER
			$message .= '</table></body></html>';
			
			$headers = "From: support@danowebstudios.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
                        //IN PRODUCTION SEND EMAIL
			//mail( get_option($thisConnection, 'adodb_error_recipient'), $subject, $message, $headers);
			
                        //IN DEV DISPLAY OUTPUT
                        echo $message;
		break;
		case 'PCONNECT':
		case 'CONNECT':
			$host = $p1;
			$database = $p2;
	
			$s = "$dbms error: [$errno: $errmsg] in $fn($host, '****', '****', $database)\n";
		break;
		default:
			$s = "$dbms error: [$errno: $errmsg] in $fn($p1, $p2)\n";
		break;
	}
	/*
	* Log connection error somewhere
	*	0 message is sent to PHP's system logger, using the Operating System's system
	*		logging mechanism or a file, depending on what the error_log configuration
	*		directive is set to.
	*	1 message is sent by email to the address in the destination parameter.
	*		This is the only message type where the fourth parameter, extra_headers is used.
	*		This message type uses the same internal function as mail() does.
	*	2 message is sent through the PHP debugging connection.
	*		This option is only available if remote debugging has been enabled.
	*		In this case, the destination parameter specifies the host name or IP address
	*		and optionally, port number, of the socket receiving the debug information.
	*	3 message is appended to the file destination
	*/
	if (defined('ADODB_ERROR_LOG_TYPE')) 
	{
		$t = date('Y-m-d H:i:s');
		if (defined('ADODB_ERROR_LOG_DEST'))
			error_log("($t) $s", ADODB_ERROR_LOG_TYPE, ADODB_ERROR_LOG_DEST);
		else
			error_log("($t) $s", ADODB_ERROR_LOG_TYPE);
	}

	//print "<p>$s</p>";
	//trigger_error($s,ADODB_ERROR_HANDLER_TYPE); 
}
?>

<?php
    //GLOBAL CONFIGURATION FILE FOR PROJECT

    //SET THE TIMEZONE
    date_default_timezone_set('America/New_York');
    ini_set("display_errors", 1);
    
    //START A SESSION
    session_start();
    
    //DEFINES FOR USE THROUGHOUT APPLICATION
    define("PROJECT_FOLDER", "/codekatas/GridPathFinding/");
    define("INCLUDES_DIR", $_SERVER['DOCUMENT_ROOT'] . PROJECT_FOLDER . 'includes/');
    
    //SET THE PROTOCOL BEING USED
    define('PROTOCOL', 'http://');
    
    //BUILD PROJECT SERVER URL
    define('SERVER_URL', 'www.danowebstudios.com' . PROJECT_FOLDER);
    
    //GET THE SITE URL TO USE EVERYWHERE THROUGHOUT THE SITE
    
    define('SITE_URL', PROTOCOL . SERVER_URL);
    
    define('ENV', "PRODUCTION");
    
    //BUILD OUR DATABASE CONNECTIONS
    require_once 'includes/adodb/adodb-errorhandler.inc.php'; 
    require_once 'includes/adodb/adodb.inc.php';
    
    switch(ENV)
        {
            case 'PRODUCTION':
            //PRODUCTION
            $hostname_DB = "127.0.0.1";
            $database_DB = "danowebs_gridpathing";
            $username_DB = "danowebs_gridpat";
            $password_DB = "~~86=ready=GOOD=august=17~~";
            break;
        
            default:
            //DEVELOPMENT
            $hostname_DB = "127.0.0.1";
            $database_DB = "danowebs_gridpathing";
            $username_DB = "danowebs_gridpat";
            $password_DB = "~~86=ready=GOOD=august=17~~";
            break;
        }//END SWITCH
	
	$ADODB = NewADOConnection('mysql');
	$ADODB->Connect($hostname_DB, $username_DB, $password_DB, $database_DB);
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
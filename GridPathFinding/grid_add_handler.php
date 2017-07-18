<?php

/* 
 * This script handles the data input (submitted) from the Add Grid Page
 * 
 * @author Dan Reed
 */

require_once "config.php";
require_once INCLUDES_DIR . "pathfinder.php";

//GET THE INPUT DATA
$grid_data = isset($_REQUEST['grid_data']) ? $_REQUEST['grid_data'] : '';
$grid_name = isset($_REQUEST['grid_name']) ? $_REQUEST['grid_name'] : '[no name provided]';

//IF WE HAVE NOTHING RETURN TO THE ADD PAGE, NO WARNING.
if($grid_data == '')
{
    header("Location: grid_add.php");
    exit();
}//END IF GRID_DATA == ''

//VARS USED LATER
$max_row_length = 0;
$grid_row_count = 0;
$storage_values = array();
$pathfinder = new pathfinder();

//WE HAVE DATA, PROCESS DATA AND BUILD GRID ROWS
$grid_data_values = explode("\n", $grid_data);
$grid_row_count = count($grid_data_values);

//IF WE HAVE BAD DATA, EXIT WITH WARNING
if($grid_row_count <= 0)
{
    $_SESSION['error_message'] = "Invalid Format Detected, Please see the example for proper formatting.";
    header("Location: grid_add.php");
    exit();
}//END IF GRID_ROW_COUNT <= 0

//STEP THROUGH EACH ROW AND BUILD OUT DATA TO STORE
for($g=0;$g < $grid_row_count;$g++)
{
    
    //TRIM ANY NEWLINE CHARACTERS TO PREVENT FALSE INTEGER DETECTION
    //echo "GRID_DATA_VALUES:" . print_r($grid_data_values[$g], true); //USED FOR DEBUGGING
    
    $grid_data_values[$g] = trim($grid_data_values[$g]);
    
    //GET SINGLE ROW TO WORK WITH
    $grid_row_values = explode(" ", $grid_data_values[$g]);
    
    //DETERMINE IF THIS SETS THE NEW MAX FOR ROW LENGTH
    if(count($grid_row_values) > $max_row_length)
    {
        $max_row_length = count($grid_row_values);
    }//END IF COUNT(GRID_ROW_VALUES) > MAX_ROW_LENGTH
    
    //STEP THROUGH EACH VALUE, SANITIZE AND PREPARE FOR STORAGE
    for($v=0;$v<count($grid_row_values);$v++)
    {
        //SANITIZE VALUES INTO EXPECTED PARAMETERS
        if(is_numeric($grid_row_values[$v]) == false )
        {
            //echo 'NON_NUMERIC:<hr />' . $grid_row_values[$v] . '<hr />';
            //NON NUMERIC VALUE
            $data_value = 0;
        } else {
            //WE HAVE A NUMERIC, FORCE IT TO INTEGER
            $data_value = floor($grid_row_values[$v]);
        }//END IF IS_NUMERIC == FALSE
        
        //SAVE TO STORAGE ARRAY
        $storage_values[$g][$v] = $data_value;
    }//END FOR V < COUNT(GRID_ROW_VALUES
    
}//END FOR G < GRID_ROW_COUNT

//STORE OUR SANITIZED DATA
$pathfinder->saveGrid($grid_name, $storage_values);

header("Location: grid_list.php");
exit();
?>

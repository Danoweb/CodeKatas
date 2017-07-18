<?php

/**
 * Pathfinding class for the Grid Pathing Code Kata
 *
 * @author daniel.reed
 */
class pathfinder 
{
    //CLASS SCOPE VARIABLES
    public $grids_id = '';
    public $grids_name = '';
    public $create_datetime = '';
    public $edit_datetime = '';
    public $active = '';
    
    /* 
     * SAVE THE GRID TO OUR DATABASE FOR LATER REVIEW OR RETREIVAL
     * 
     * @name saveGrid
     * @param grid_name = [string] - The Name used for this grid reference.
     * @param grid_data_array = [array] - A 2-dimensional array representing the GRID data.
     */
    public function saveGrid($grid_name, $grid_data_array)
    {
        //GET OUR DB OBJECT TO WORK WITH
        global $ADODB;
        
        //CREATE OUR INITIAL GRID RECORD
        $create_grid_sql = "INSERT INTO grids (grids_name, create_datetime) VALUES (?, NOW())";
        $create_grid_result = $ADODB->Execute($create_grid_sql, array($grid_name));
        $create_grid_id = $ADODB->Insert_ID();
        
        //ADD DATA FOR EACH ROW
        for($g=0;$g<count($grid_data_array);$g++)
        {
                        
            //ADD RECORD TO TABLE
            $create_row_sql = "INSERT INTO grids_rows 
                                    (grids_id, 
                                    row_data, 
                                    create_datetime) 
                                VALUES 
                                    (?,
                                     ?,
                                     NOW())";
            $create_row_result = $ADODB->Execute($create_row_sql, array($create_grid_id, implode(",", $grid_data_array[$g])));
        }//END FOR G < COUNT(GRID_DATA_ARRAY)
        
        //RETURN THE NEWLY CREATED GRID ID.
        return $create_grid_id;
    }//END FUNCTION SAVEGRID
    
    /*
     * GET THE EXISTING GRID DATA IN AN EASY TO CONSUME FORMAT
     */
    public function getGrids()
    {
        //VALUES USED LATER
        global $ADODB;
        $output = array();
        
        //GET OUR GRIDS FORM THE DATABASE
        $grids_sql = "SELECT
                        grids.grids_id,
                        grids.grids_name,
                        (SELECT GROUP_CONCAT(DISTINCT grids_rows.row_data SEPARATOR '|') FROM grids_rows WHERE grids_rows.grids_id = grids.grids_id) AS grids_values
                    FROM
                        grids
                    WHERE 
                        grids.active='Y'";
        $grids_result = $ADODB->Execute($grids_sql);
        $grids_count = $grids_result->RecordCount();
        
        //LOOP THROUGH EACH GRID AND PREPARE OUTPUT
        for($g=0;$g<$grids_count;$g++)
        {
            $grids_result->Move($g);
            
            $grids_answer = $grids_result->GetRowAssoc(false);
            
            $output[$g] = $grids_answer;
        }//END FOR G < GRIDS_COUNT
        
        return $output;
    }//END FUNCTION GETGRIDS
    
    public function loadGrid($grids_id)
    {
        //VALUES USED LATER
        global $ADODB;
        $output = array();
        
        //GET OUR GRIDS FORM THE DATABASE
        $grids_sql = "SELECT
                        grids.grids_id,
                        grids.grids_name,
                        GROUP_CONCAT(grids_rows.row_data SEPARATOR '|') AS grids_values
                    FROM
                        grids
                        INNER JOIN grids_rows ON grids.grids_id = grids_rows.grids_id
                    WHERE 
                        grids.grids_id = ?";
        $grids_result = $ADODB->Execute($grids_sql, array($grids_id));
        $grids_answer = $grids_result->GetRowAssoc(false);
        
        $output = $grids_answer;
        
        return $output;
    }//END FUNCTION LOADGRID
    
    
    /*
     * @summary FIND THE SHORTEST PATH THROUGH THE GRID.
     * @description Think of it like a file, and adjusting a file/character pointer. Track progress as it moves. Utilize a 2-dimensional array representing x/y coordinates.
     * 
     * @author Dan Reed
     */
    public function findShortestPathGrid($grid_values, $new_row_delimiter = "|", $value_delimiter = ",")
    {
        //VARS USED LATER
        $grid = array();
        $output = array();
        $attempts = array();
        $output['completed'] = '';
        $output['cost'] = 0;
        $output['path'] = '';
        
        //SEPARATE OUR VALUES TO WORK WITH
        $grid_rows = explode($new_row_delimiter, $grid_values);
        $grid_rows_count = count($grid_rows);
        
        //BUILD OUR GRID TO WORK WITH
        for($g=0;$g<$grid_rows_count;$g++)
        {
            $grid_row_values = explode($value_delimiter, $grid_rows[$g]);
            
            for($v=0;$v<count($grid_row_values);$v++)
            {
                $grid[$g][$v] = $grid_row_values[$v];
            }//END FOR V < COUNT(GRID_ROW_VALUES)
        }//END FOR G < COUNT(GRID_ROWS)
        
        //print_r($grid); //USED FOR DEBUGGING
        
        //WE HAVE OUR DATA LET'S FIND THE SHORTEST PATH.
        //STEP THROUGH EACH PRIMARY POSITION AND WORK A PATH OF LEAST COST
        for($a=0;$a<$grid_rows_count;$a++)
        {
            //UPDATE OUR ATTEMPT WITH OUR INITIAL COST
            $attempts[$a]['cost'] = $grid[$a][0];
            $attempts[$a]['path'] = ($a + 1);
            
            //SET OUR INITIAL POINTER LOCATION
            $grid_pointer['y'] = $a;
            $grid_pointer['x'] = 0;
            
            //MOVE RIGHT THROUGH THE GRID FINDING THE PATH
            $end = false;
            while($end == false)
            {
                //GET THE NEIGHBOR HIGH TILE
                if($grid_pointer['y'] != 0)
                {
                    //GET EXPECTED VALUE AT PLACE
                    $high_y = $grid_pointer['y']-1;
                    $high_x = $grid_pointer['x']+1;
                    $high = $grid[$high_y][$high_x];
                } else {
                    //WRAP TO OTHER SIDE
                    $high_y = $grid_rows_count-1;
                    $high_x = $grid_pointer['x']+1;
                    $high = $grid[$high_y][$high_x];
                }//END IF ISSET(GRID{a-1})

                //GET THE NEIGHBOR MID TILE
                $mid_y = $grid_pointer['y'];
                $mid_x = $grid_pointer['x']+1;
                $mid = $grid[$mid_y][$mid_x];

                //GET THE NEIGHBOR LOW TILE
                if($grid_pointer['y']+1 >= $grid_rows_count)
                {
                    //WE NEED TO WRAP -  BACK TO TOP MOST GRID POSITION (0)
                    $low_y = 0;
                    $low_x = $grid_pointer['x']+1;
                    $low = $grid[$low_y][$low_x];
                } else {
                    //GET EXPECTED VALUE AT PLACE
                    $low_y = $grid_pointer['y']+1;
                    $low_x = $grid_pointer['x']+1;
                    $low = $grid[$low_y][$low_x];
                }//END IF GRID_POINTER{Y}+1
                
                //DETERMINE WHICH IS BEST (LOWEST) COST
                if($high <= $mid and $high <= $low)
                {
                    //HIGH IS LOWEST COST
                    $attempts[$a]['cost'] += $high;
                    $attempts[$a]['path'] .= ' ' . ($high_y + 1);
                    
                    //ADJUST OUR POINTER
                    $grid_pointer['y'] = $high_y;
                    $grid_pointer['x'] = $high_x;
                }
                elseif($mid <= $high and $mid <= $low)
                {
                    //MID IS LOWEST COST
                    $attempts[$a]['cost'] += $mid;
                    $attempts[$a]['path'] .= ' ' . ($mid_y + 1);
                    
                    //ADJUST OUR POINTER
                    $grid_pointer['y'] = $mid_y;
                    $grid_pointer['x'] = $mid_x;
                }
                else
                {
                    //LOW IS LOWEST COST
                    $attempts[$a]['cost'] += $low;
                    $attempts[$a]['path'] .= ' ' . ($low_y + 1);
                    
                    //ADJUST OUR POINTER
                    $grid_pointer['y'] = $low_y;
                    $grid_pointer['x'] = $low_x;
                }//END IF HIGH < MID AND HIGH < LOW
                
                //echo '<br />A: ' . $a . ' X: ' . $grid_pointer['x'] . ' - HIGH: ' . $high . ' - MID: ' . $mid . ' - LOW: ' . $low . ' = ' . (count($grid[0]) - $grid_pointer['x']) . ' | ' . $grid_pointer['y'] . '-' . $grid_pointer['x'] . '<br />'; //USED FOR DEBUGGING
                
                
                //DETERMINE IF WE ARE DONE CROSSING THE GRID, (NEED TO MOVE N-1 ITEMS AS WE DONT CHECK THE FIRST ITEM)
                if( $grid_pointer['x'] < (count($grid[0])-1) )
                {
                    $end = false;
                } else {
                    $end = true;
                }//END IF GRID_POINTER{Y} == GRID_ROWS_COUNT
            }//END WHILE END == FALSE
            
        }//END FOR A < COUNT(GRID_ROWS)
        
        //echo 'Attempts: ' . print_r($attempts, true); //USED FOR DEBUGGING
        
        //DETERMINE WHICH ATTEMPT HAD THE LOWEST COST
        $attempt_lowest = -1;
        $attempt_lowest_value = 50;
        
        for($c=0;$c<count($attempts);$c++)
        {
            //DETERMINE COSTS PLACEMENT
            if($attempts[$c]['cost'] < $attempt_lowest_value and $attempts[$c]['cost'] < 50)
            {
                //THIS ONE TAKE THE LEAD
                $attempt_lowest = $c;
                $attempt_lowest_value = $attempts[$c]['cost'];
            }//END IF ATTEMPTS{COST} < ATTEMPT_LOWEST_VALUE
        }//END FOR C < COUNT(ATTEMPTS
        
        //DETERMINE OUR FAIL OUTPUT
        if($attempt_lowest == -1)
        {
            //NO ATTEMPT MADE IT ACROSS UNDER 50 COST.
            $output['cost'] = '';
            $output['path'] = '';
            $output['completed'] = 'No';
        } else {
            //STORE OUR SUCCESSFUL ATTEMPT AS OUR OUTPUT
            $output['cost'] = $attempts[$attempt_lowest]['cost'];
            $output['path'] = $attempts[$attempt_lowest]['path'];
            $output['completed'] = 'Yes';
        }//END IF ATTEMPT_LOWEST == ''
        
        return $output;
    }//END FUNCTION FINDSHORTESTPATHGRID
}//END CLASS PATHFINDER

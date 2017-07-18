<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include "header.php";
include INCLUDES_DIR . 'pathfinder.php';

//GET OUR GRID DATA (IF NON PROVIDED DISPLAY WARNING)
$grids_id = isset($_REQUEST['grids_id']) ? $_REQUEST['grids_id'] : '';

if($grids_id == '')
{
    echo '<div class="container"><div class="row"><div class="col-sm-12 col-md-12 col-lg-12"><h2>No Grid was Selected, Please return to the Grid List page and try again.</h2></div></div></div>';
    
    include "footer.php";
    exit();
}//END IF GRIDS_ID == ''

//GET THE PROVIDED GRID INFO FROM THE 
$pathfinder = new pathfinder();
        
$display_grid = $pathfinder->loadGrid($grids_id);
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <header class="jumbotron hero-spacer">
                <h1>Grid Details</h1>
                <p>
                    This page shows the details for the selected grid.<br />
                    
                </p>
            </header>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <label>Grid Name:</label> <span><?php echo $display_grid['grids_name']; ?></span><br />
            <div class="well well-sm"><?php echo str_replace("|", "<br />", $display_grid['grids_values']); ?></div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <?php
            $grids_output = $pathfinder->findShortestPathGrid($display_grid['grids_values']);
            ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Path Finding Outcome:</h3>
                </div>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <label>Path Completed?</label>
                        </div>
                        
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <?php echo $grids_output['completed']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <label>Path Cost:</label>
                        </div>
                        
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <?php echo $grids_output['cost']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <label>Path Taken:</label>
                        </div>
                        
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <?php echo $grids_output['path']; ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?php
    include "footer.php";
?>
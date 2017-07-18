<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include "header.php";
require_once INCLUDES_DIR . 'pathfinder.php';
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <header class="jumbotron hero-spacer">
                <h1>Grid List</h1>
                <p>
                    Below is the list of grids that have been submitted to the system.<br />
                    &bull; To run a grid, click the "View" button in the grid's row.
                </p>
            </header>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <?php
                //GET OUR GRIDS FROM THE SYSTEM
                $pathfinder = new pathfinder();
                
                $grids_display = $pathfinder->getGrids();
            ?>
            
            <table id="grids_list_table" class="table table-striped table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <td>Grid Name</td>
                        <td>Grid</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //LOOP THROUGH EACH GRID
                        for($g=0;$g<count($grids_display);$g++)
                        {
                            echo '<tr>';
                            
                            //OUTPUT NAME
                            echo '<td>' . $grids_display[$g]['grids_name'] . '</td>';
                            
                            //OUTPUT DATA VALUES
                            echo '<td>' . str_replace('|', '<br />', $grids_display[$g]['grids_values']) . '</td>';
                            
                            //ACTIONS
                            echo '<td><a href="grid_details.php?grids_id=' . $grids_display[$g]['grids_id'] . '" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> View</a></td>';
                            
                            echo '</tr>';
                        }//END FOR G < COUNT(GRIDS_DISPLAY)
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#grids_list_table').DataTable({
            responsive: true,    
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    } );
</script>
<?php
    include "footer.php";
?>
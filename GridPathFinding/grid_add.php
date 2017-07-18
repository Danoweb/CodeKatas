<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include "header.php";
?>
<!-- Page Content -->
    <div class="container">
        <?php
            //IF WE HAVE AN ALERT DISPLAY IT, THEN REMOVE IT FROM SESSION TRACKING
            if(isset($_SESSION['error_message']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php echo $_SESSION['error_message']; ?></strong>
                </div>
                
                <?php
                //REMOVE FROM ERROR SESSION TRACKING
                unset($_SESSION['error_message']);
            }//END IF ISSET($_SESSION{ERROR_MESSAGE})
        
        ?>
        <form name="add_grid_form" id="add_grid_form" action="grid_add_handler.php" enctype="multipart/form-data" method="POST">
            <div class="row text-center">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <h3>Add Grid to System</h3>
                    <hr />
                    <p>This form will walk you through adding a grid to the system.</p>
                    <p>&bull; Grid rows are a series of space (" ") separated integer (whole number) values.</p>
                    <p>&bull; All rows in a grid must be the same length (if omitted Zero values will be added)</p>
                    <p>&bull; Values can be negative or positive</p>
                    <p>&bull; Invalid inputs will be converted to 0</p>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                            <label>Example:</label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                            <div class="well well-sm">
                                <p>
                                3 4 1 2 8 6<br />
                                6 1 8 2 7 4<br />
                                5 9 3 9 9 5<br />
                                8 4 1 3 2 6<br />
                                3 7 2 8 6 4<br />
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                            <label for="grid_data">Grid Data:</label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                            <textarea name="grid_data" id="grid_data" class="form-control" cols="6" rows="5"></textarea> 
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                            <label for="grid_name">Grid Name:</label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                            <input type="text" name="grid_name" id="grid_name" class="form-control" /> 
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <a href="javascript:void(0);" class="btn btn-lg btn-success" onclick="$('#add_grid_form').submit();">
                                <span class="glyphicon  glyphicon-plus-sign"></span> Add Grid
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
<?php
    include "footer.php";
?>
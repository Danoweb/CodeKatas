<?php
    include "header.php";
?>
    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Grid Pathfinding</h1>
            <p>The objective is to find the path of lowest cost when moving across a grid. For this
challenge, you are provided a grid of integers where each integer represents the
amount of cost encountered at a given point on the grid. A path enters the grid from
the left (at any point) and passes through the grid to the right, moving only one
column per round. Movement is always to an adjacent column, meaning the path
can proceed horizontally or diagonally. For the sake of this challenge, we assume the
first and last row are also adjacent. Effectively, the grid “wraps”.</p>
            <p>The total cost of a path is the sum of the integers in each of the visited cells. The
solution needs to handle grids of various sizes with a minimum of 1 row and 5
columns up to 10 rows and 100 columns. If in the next move, the total cost will
exceed 50, that path is abandoned.</p>
            <br />
            <p>The purpose of this challenge is to find the path of least cost (that is, the path with
the lowest total cost of any possible path). The paths of least cost through two
slightly different 5 x 6 grids are shown below. The grid values differ only in the
bottom row. The path for the grid on the right takes advantage of the adjacency
between the first and last rows.</p>
            <a href="<?php echo SITE_URL; ?>grid_list.php" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-list"></span> View Grids</a>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Items of Interest</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="<?php echo SITE_URL; ?>/images/codekata.jpg" alt="CodeKata">
                    <div class="caption">
                        <h3>www.codekatas.org</h3>
                        <p>A code kata is an exercise in programming which helps a programmer hone their skills through practice and repetition.</p>
                        <p>
                            <a href="http://www.codekatas.org" class="btn btn-primary" target="_blank">www.codekatas.org</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="<?php echo SITE_URL; ?>/images/linkedin.jpg" alt="LinkedIn">
                    <div class="caption">
                        <h3>Developer Story</h3>
                        <p>Dan Reed's LinkedIn Profile.</p>
                        <p>
                            <a href="https://www.linkedin.com/in/danreed1986/" class="btn btn-primary" target="_blank">View LinkedIn</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="<?php echo SITE_URL; ?>/images/php.png" alt="PHP">
                    <div class="caption">
                        <h3>PHP</h3>
                        <p>Check out all the great details on this exciting development language at php.net.</p>
                        <p>
                            <a href="http://www.php.net" class="btn btn-primary" target="_blank">PHP.net</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="<?php echo SITE_URL; ?>/images/bootstrap.png" alt="Bootstrap">
                    <div class="caption">
                        <h3>Bootstrap Framework</h3>
                        <p>Take a look at this Responsive, Mobile first jQuery framework at getbootstrap.com</p>
                        <p>
                            <a href="http://getbootstrap.com/getting-started/" class="btn btn-primary" target="_blank">Bootstrap</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <hr>

<?php
    include "footer.php";
?>

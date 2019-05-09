<!DOCTYPE html>
<html lang="en">
<head>

    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

        <style type="text/css">
        .wrapper{
        width: 650px;
        margin: 0 auto;
        margin-top: 100px;
        }
        .page-header h2{
        margin-top: 0;
        }
        table tr td:last-child a{
        margin-right: 15px;
        }
        </style>
        <script type="text/javascript">
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Employees Details</h2>
                            <a href="create.php" class="btn btn-success pull-right">Add New Employee</a>

                        </div>
                        <?php
                        include 'navbar.php';
                        // Include config file
                        require_once 'config.php';

                        // Attempt select query execution
                        $sql = "SELECT * FROM employees";
                        if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>Name</th>";
                                    echo "<th>Address</th>";
                                    echo "<th>Salary</th>";
                                    echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                                while($row = $result->fetch_array()){
                                echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['address'] . "</td>";
                                    echo "<td>" . $row['salary'] . "</td>";
                                    echo "<td>";
                                        echo "<a href='read.php?id=". $row['id'] ." 'title='View Record' data-toggle='tooltip'><i class='fas fa-eye'></i></a>";
                                        echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><i class='fas fa-hourglass'></i></a>";
                                        echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><i class='fas fa-trash-alt'></i></a>";
                                    echo "</td>";
                                echo "</tr>";
                                }
                            echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        $result->free();
                        } else{
                        echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                        } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                        }

                        // Close connection
                        $mysqli->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

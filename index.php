<!-- Name: Huixin Xu
Due Date: Apr 10, 2023
Section: CST8285 313
Lab: 23W Assignment2
File: index.php
Lab objective: Create PHP server web pages corresponding to CRUD operations for one entity.
-->

<!-- <?php require_once('./movieDAO.php'); ?> -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie - Huixin Xu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>

<body>
    <div class="wrapper">
            <div class="container-fluid">
                <div class="movie">
                    <div class="col-md-12">
                        <div class="mt-5 mb-3 clearfix">
                            <h2 class="pull-left">Movie info</h2>
                            <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Movie</a>
                        </div>
                        <?php
                            $movieDAO = new movieDAO();
                            $movies = $movieDAO->getMovies();

                            if($movies){
                                echo '<table class="table table-bordered table-striped">';
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>#</th>";
                                            echo "<th>Name</th>";
                                            echo "<th>Release Date</th>";
                                            echo "<th>Length(min)</th>";
                                            echo "<th>Poster</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    foreach ($movies as $movie) {
                                        echo "<tr>";
                                            echo "<td>" . $movie->getId(). "</td>";
                                            echo "<td>" . $movie->getName() . "</td>";
                                            echo "<td>" . $movie->getRelease_Date() . "</td>";
                                            echo "<td>" . $movie->getLength() . "</td>";
                                            echo "<td>" . $movie->getPoster() . "</td>";
                                            echo "<td>";
                                                echo '<a href="read.php?id='. $movie->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                                echo '<a href="update.php?id='. $movie->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                                echo '<a href="delete.php?id='. $movie->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set
                                //$result->free();
                            } else{
                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            }
                        // Close connection
                        $movieDAO->getMysqli()->close();
                        include 'footer.php';
                        ?>
                    </div>
                </div>        
            </div>
        </div>


</body>
</html>
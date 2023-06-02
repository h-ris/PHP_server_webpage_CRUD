<?php

// Include movieDAO file
require_once('./movieDAO.php');
$movieDAO = new movieDAO();


// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Get URL parameter
    $id = trim($_GET["id"]);
    $movie = $movieDAO->getMovie($id);

    if ($movie) {
        // Retrieve individual field value
        $name = $movie->getName();
        $release_date = $movie->getRelease_Date();
        $length = $movie->getLength();
        $poster = $movie->getPoster();
        $image_path = "img/" . $poster;
    } else {
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

// Close connection
$movieDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Product Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Movie Record</h1>

                    <!-- display movie name -->
                    <div class="form-group">
                        <label>Movie Name</label>
                        <p><b>
                                <?php echo $name; ?>
                            </b></p>
                    </div>

                    <!-- display length -->
                    <div class="form-group">
                        <label>Length</label>
                        <p><b>
                                <?php echo $length; ?>
                            </b></p>
                    </div>

                    <!-- display release date -->
                    <div class="form-group">
                        <label>Release Date</label>
                        <p><b>
                                <?php echo $release_date; ?>
                            </b></p>
                    </div>

                    <!-- display poster -->
                    <div class="form-group">
                        <label>Poster</label>
                        <p><b>
                                <?php echo (!empty($poster)) ? "<img src='$image_path' alt='poster' width='350'>" : "Please upload a poster."; ?>
                            </b></p>
                    </div>


                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

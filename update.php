<?php

// Include movieorderDAO file
require_once('./movieDAO.php');

// Define variables and initialize with empty values
$name = $release_date = $length = $poster = "";
$name_err = $release_date_err = $length_err = $poster_err = "";
$movieDAO = new movieDAO();
$oldFileName = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];
    $previousFileName = $_POST["oldFileName"];

    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a movie name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9\s]+$/")))) {
        $name_err = "Please enter a valid movie name.";
    } else {
        $name = $input_name;
    }

    $input_length = trim($_POST["length"]);
    if (empty($input_length)) {
        $length_err = "Please enter the length of movie.";
    } elseif (intval($input_length) < 0 || intval($input_length) > 9999) {
        $length_err = "Movie length must be between 0 and 9999.";
    } else {
        $length = $input_length;
    }

    $input_release_date = $_POST["release_date"];
    if (empty($input_release_date)) {
        $release_date_err = "Please enter a movie release date.";
    } else {
        $newReleaseDate = new DateTime($input_release_date);
        $today = new DateTime('now', new DateTimeZone('America/Toronto'));
        if ($newReleaseDate > $today) {
            $release_date_err = "Please input a valid release date";
        } else {
            $release_date = $input_release_date;
        }
    }

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //validator
    if (isset($_FILES["poster"])) {
        $poster = $_FILES["poster"]["name"];
        $file_size = $_FILES["poster"]["size"];
        $file_tmp = $_FILES["poster"]["tmp_name"];

        if ($file_size > 10485760) {
            $poster_err = "Faild to upload: File size must be less than 10 MB";
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        //file upload
        if (empty($name_err) && empty($release_date_err) && empty($length_err) && empty($poster_err)) {
            move_uploaded_file($file_tmp, "img/" . $_FILES["poster"]["name"]);
        }
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($release_date_err) && empty($length_err) && empty($poster_err)) {
        if (empty($poster)) {    
        $poster = $previousFileName;
        }

        $movie = new movie($id, $name, $release_date, $length, $poster);
        $result = $movieDAO->updateMovie($movie);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $movieDAO->getMysqli()->close();
    }

} else {
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the movie record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post"
                        enctype="multipart/form-data">

                        <!-- Input for customer name -->
                        <div class="form-group">
                            <label>Movie Name</label>
                            <input type="text" name="name"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $name_err; ?>
                            </span>
                        </div>

                        <!-- Input for quantity -->
                        <div class="form-group">
                            <label>Length</label>
                            <input type="number" name="length"
                                class="form-control <?php echo (!empty($length_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $length; ?>">
                            <span class="invalid-feedback">
                                <?php echo $length_err; ?>
                            </span>
                        </div>

                        <!-- Input for update date -->
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="release_date"
                                class="form-control <?php echo (!empty($release_date_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $release_date; ?>">
                            <span class="invalid-feedback">
                                <?php echo $release_date_err; ?>
                            </span>
                        </div>

                        <!-- image file upload -->
                        <div class="form-group">
                            <label>Upload Poster</label>
                            <input type="file" name="poster"
                                class="form-control <?php echo (!empty($poster_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $poster; ?>" />
                            <span class="invalid-feedback">
                                <?php echo $poster_err; ?>
                            </span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="oldFileName" value="<?php echo $oldFileName; ?>" />

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

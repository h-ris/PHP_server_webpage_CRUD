<?php

error_reporting(E_ALL);
// Include movieDAO file
require_once('./movieDAO.php');

// Define variables and initialize with empty values
$name = $release_date = $length = $poster = "";
$name_err = $release_date_err = $length_err = $poster_err = "";
date_default_timezone_set('America/Toronto');

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter movie name.";
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
        $target_dir = "img/";
        $poster2 = $target_dir . basename($_FILES["poster"]["name"]);
        $poster = $_FILES["poster"]["name"];
        $file_size = $_FILES["poster"]["size"];
        $file_tmp = $_FILES["poster"]["tmp_name"];

        // check file size
        if ($file_size > 10485760) {
            $poster_err = "Faild to upload: File size must be less than 10 MB";
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }
        

        if (move_uploaded_file($_FILES["poster"]["tmp_name"], $poster2)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["poster"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($release_date_err) && empty($length_err) && empty($poster_err)) {
        //move_uploaded_file($file_tmp, "img/" . $_FILES["poster"]["name"]);
        $movieDAO = new movieDAO();
        $movie = new movie(0, $name, $release_date, $length, $poster);
        $addResult = $movieDAO->addMovie($movie);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        // Close connection
        $movieDAO->getMysqli()->close();
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add new product record to the database.</p>

                    <!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        enctype="multipart/form-data">

                        <!-- Input for movie name -->
                        <div class="form-group">
                            <label>Movie Name</label>
                            <input type="text" name="name"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $name_err; ?>
                            </span>
                        </div>

                        <!-- Input for length -->
                        <div class="form-group">
                            <label>Length</label>
                            <input type="number" name="length"
                                class="form-control <?php echo (!empty($length_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $length; ?>">
                            <span class="invalid-feedback">
                                <?php echo $length_err; ?>
                            </span>
                        </div>

                        <!-- Input for release date -->
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="release_date"
                                class="form-control <?php echo (!empty($release_date_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $release_date; ?>">
                            <span class="invalid-feedback">
                                <?php echo $release_date_err; ?>
                            </span>
                        </div>

                        <!-- poster image file upload -->
                        <div class="form-group">
                            <label>Upload Poster</label>
                            <input type="file" accept="image/*" name="poster"
                                class="form-control <?php echo (!empty($poster_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $poster; ?>" />
                            <span class="invalid-feedback">
                                <?php echo $poster_err; ?>
                            </span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <? include 'footer.php'; ?>
    </div>
</body>
</html>

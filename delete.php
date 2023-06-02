<?php

/* Name: Huixin Xu
Due Date: Apr 10, 2023
Section: CST8285 313
Lab: 23W Assignment2
File: delete.php
Lab objective: Create PHP server web pages corresponding to CRUD operations for one entity.
*/

// Include movieDAO file
require_once('./movieDAO.php');

// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
        $movieDAO = new movieDAO();  
        $movieId = trim($_POST["id"]);        
        $result = $movieDAO->deleteMovie($movieId);
        if($result){
            header("location: index.php");
            exit();
            } else{
            echo "Oops! Something went wrong. Please try again later.";
            }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
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
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this movie record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
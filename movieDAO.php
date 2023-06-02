<?php

/* Name: Huixin Xu
Due Date: Apr 10, 2023
Section: CST8285 313
Lab: 23W Assignment2
File: movieDAO.php
Lab objective: Create PHP server web pages corresponding to CRUD operations for one entity.
*/

require_once('abstractDAO.php');
require_once('./movie.php');

class movieDAO extends abstractDAO {

    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function getMovie($movieId){
        $query = 'SELECT * FROM movies WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $movieId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1) {
            $temp = $result->fetch_assoc();
            $movie = new movie($temp['id'],$temp['name'],$temp['release_date'],$temp['length'],$temp['poster']);
            $result->free();
            return $movie;
        }
        $result->free();
        return false;
    }


    //returns a mysqli_result object
    public function getMovies(){
        $result = $this->mysqli->query('SELECT * FROM movies');
        $movies = array();

        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $movie = new movie($row['id'],$row['name'],$row['release_date'],$row['length'],$row['poster']);
                $movies[] = $movie;
            }
            $result->free();
            return $movies;
        }
        $result->free();
        return false;
    }


    public function addMovie($movie){

        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a placeholder for the parameters to be used in the query.
            //The prepare method of the mysqli object returns a mysqli_stmt object. It takes a parameterized query as a parameter.
			$query = 'INSERT INTO movies (name, release_date, length, poster) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                $name = $movie->getName();
                $release_date = $movie->getRelease_Date();
                $length = $movie->getLength();
                $poster = $movie->getPoster();

                //type for date ???
                $stmt->bind_param('ssis', $name, $release_date, $length, $poster);
                $stmt->execute();         
                    
                if($stmt->error){
                    return $stmt->error;
                } else {
                    return $movie->getName() . ' added successfully!';
                } 
			}
            else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }

            }
            else {
                return 'Could not connect to Database.';
            }
    }


    public function updateMovie($movie){

        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a placeholder for the parameters to be used in the query.
            //The prepare method of the mysqli object returns a mysqli_stmt object. It takes a parameterized query as a parameter.
			$query = "UPDATE movies SET name=?, release_date=?, length=?, poster=? WHERE id=?";
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                $id = $movie->getId();
                $name = $movie->getName();
                $release_date = $movie->getRelease_Date();
                $length = $movie->getLength();
                $poster = $movie->getPoster();

                //type for date ???
                $stmt->bind_param('issis', $id, $name, $release_date, $length, $poster);
                $stmt->execute();         
                    
                if($stmt->error){
                    return $stmt->error;
                } else {
                    return $movie->getName() . ' updated successfully!';
                } 
			}
            else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }

            }
            else {
                return 'Could not connect to Database.';
            }
    }


    public function deleteMovie($movieId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM movies WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $movieId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        }
        else {
            return false;
        }
    }


}
?>



















}
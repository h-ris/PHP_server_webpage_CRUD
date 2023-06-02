<?php

/* Name: Huixin Xu
Due Date: Apr 10, 2023
Section: CST8285 313
Lab: 23W Assignment2
File: movie.php
Lab objective: Create PHP server web pages corresponding to CRUD operations for one entity.
*/

    class Movie{
        private $id;
        private $name;
        private $release_date;
        private $length;
        private $poster;

        function __construct($id, $name, $release_date, $length, $poster){
            $this->setId($id);
            $this->setName($name);
            $this->setRelease_Date($release_date);
            $this->setLength($length);
            $this->setPoster($poster);
        }


        public function getName(){
            return $this->name;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getRelease_Date(){
            return $this->release_date;
        }

        public function setRelease_Date($release_date){
            $this->release_date = $release_date;
        }

        public function getLength(){
            return $this->length;
        }

        public function setLength($length){
            $this->length = $length;
        }

        public function getPoster(){
            return $this->poster;
        }

        public function setPoster($poster){
            $this->poster = $poster;
        }

        public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}




    }
?>
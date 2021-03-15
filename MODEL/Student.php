<?php

    class Student {
        private $conn;
        private $table = 'student';
        private $studentReigsterTable = 'student_waiting';

        public $student_id;
        public $firstname;
        public $middlename;
        public $lastname;
        public $email;
        public $contact_number;
        public $course;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function registerStudent() {
            try {
                $query = 'INSERT INTO ' . $this->studentReigsterTable . '
                SET
                    student_id = :student_id,
                    firstname = :firstname,
                    middlename = :middlename,
                    lastname = :lastname,
                    email = :email,
                    contact_number = :contact_number,
                    course = :course';
            $stmt = $this->conn->prepare($query);

            $this->student_id = htmlspecialchars(strip_tags($this->student_id));
            $this->firstname = htmlspecialchars(strip_tags($this->firstname));
            $this->middlename = htmlspecialchars(strip_tags($this->middlename));
            $this->lastname = htmlspecialchars(strip_tags($this->lastname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
            $this->course = htmlspecialchars(strip_tags($this->course));

            $stmt->bindParam(':student_id', $this->student_id);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':middlename', $this->middlename);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':contact_number', $this->contact_number);
            $stmt->bindParam(':course', $this->course);

            $stmt->execute();
            return true;
        }    
            catch (PDOException $err){
                echo    '<div class="alert alert-dismissible alert-danger" >';
                echo        '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo        '<strong>Oh snap!</strong> student ID may already be in use or something went wrong on the server please enter another student id or try again later.';
                echo    '</div>';
                return false;
            }
        }
    }

?>
<?php

    class Achiever {
        private $conn;
        private $table = 'current_achievers';

        public $achiever_ID;
        public $rank;
        public $student_ID;
        public $firstname;
        public $middlename;
        public $lastname;
        public $course;
        public $section;
        public $schoolyear;
        public $gpa;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function viewTopAchievers() {
            $query = 'SELECT 
                student_id,
                firstname,
                middlename,
                lastname,
                course,
                section,
                gpa
            FROM 
            ' .$this->table . '
            ORDER BY gpa
            LIMIT 20';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function viewAchievers() {
            $query = 'SELECT
                student_id,
                firstname,
                middlename,
                lastname,
                course,
                section,
                gpa
            FROM
            ' .$this->table .'
            ORDER BY lastname';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }

?>
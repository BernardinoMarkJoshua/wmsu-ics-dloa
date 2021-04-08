<?php

    class Faculty {
        private $conn;
        private $facultyMembers = 'faculty_members';
        private $studentReigsterTable = 'student_waiting';
        private $studentApproved = 'student';
        private $appformApproved = 'appform_approved';
        private $appformWaiting = 'appform';
        private $adviserInfo = 'adviser_info';
        private $gradeTable = 'grades';

        public $faculty_id;
        public $email;
        public $name;
        public $password;
        public $section;
        public $course;
        public $year;
        public $role;
        public $contact_number;
        public $student_id;
        public $firstname;
        public $middlename;
        public $lastname;
        public $gpa;

        public function __construct($db){
            $this->conn = $db;
        }

        public function registerFaculty() {

            try {
                $query = 'INSERT INTO ' . $this->facultyMembers . '
                SET
                    faculty_id = :faculty_id,
                    email = :email,
                    name = :name,
                    password = :password,
                    role = :role,
                    contact_number = :contact_number';

                $stmt = $this->conn->prepare($query);


                $this->faculty_id = htmlspecialchars(strip_tags($this->faculty_id));
                $this->email = htmlspecialchars(strip_tags($this->email));
                $this->name = htmlspecialchars(strip_tags($this->name));
                $this->password = htmlspecialchars(strip_tags($this->password));
                $this->role = htmlspecialchars(strip_tags($this->role));
                $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
    
                $stmt->bindParam(':faculty_id', $this->faculty_id);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':password', $this->password);
                $stmt->bindParam(':role', $this->role);
                $stmt->bindParam(':contact_number', $this->contact_number);
    
                $stmt->execute();
                return true;

            } catch (PDOException $err) {
                echo "ERROR";
                return false;
            }
        }

        public function loginFaculty() {
            try { 
                $query = 'SELECT
                    faculty_id,
                    name,
                    email,
                    role,
                    password
                FROM
                ' . $this->facultyMembers . '
                WHERE faculty_id = :faculty_id';

                $stmt = $this->conn->prepare($query);
                $this->faculty_id = htmlspecialchars(strip_tags($this->faculty_id));

                $stmt->bindParam(':faculty_id', $this->faculty_id);

                $stmt->execute();
                return $stmt;
            } 

            catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function viewStudentWaiting() {
            $query = 'SELECT
                student_id,
                firstname,
                middlename,
                lastname,
                contact_number,
                email,
                course
            FROM
            ' .$this->studentReigsterTable .'
            ORDER BY lastname';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function acceptStudentWaiting() {
            try {
                $query = 'INSERT INTO ' . $this->studentApproved . ' (student_id, firstname, middlename, lastname, email, contact_number, course)
                SELECT
                    student_id,
                    firstname,
                    middlename,
                    lastname,
                    email,
                    contact_number,
                    course
                FROM student_waiting
                WHERE student_id = :student_id; 
                DELETE FROM student_waiting
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));

                $stmt->bindParam(':student_id',$this->student_id);

                $stmt->execute();
                return true;
            }

            catch (PDOException $err){
                echo 'failed';
                return false;
            }
        }

        public function declineStudentWaiting() {
            try {
                $query = 'DELETE FROM '.$this->studentRegisterTable. '
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));

                $stmt->bindParam(':student_id', $this->student_id);

                $stmt->execute();
                return true;
            } catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function declineStudenGrade() {
            try {
                $query = 'DELETE FROM '.$this->gradeTable. '
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));

                $stmt->bindParam(':student_id', $this->student_id);

                $stmt->execute();
                return true;
            } catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function viewStudent() {
            $query = 'SELECT
                student_id,
                firstname,
                middlename,
                lastname,
                contact_number,
                email,
                course
            FROM
            ' .$this->studentApproved .'
            ORDER BY lastname';


            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function readAdviserInfo() {
            $query = 'SELECT 
                adviser_course,
                adviser_year,
                adviser_section,
                adviser_semester 
            FROM '.$this->adviserInfo. '
            WHERE faculty_id = :faculty_id';
            
            $stmt = $this->conn->prepare($query);

            $this->faculty_id = htmlspecialchars(strip_tags($this->faculty_id));

            $stmt->bindParam(':faculty_id', $this->faculty_id);

            $stmt->execute();
            return $stmt;
        }
        

        public function viewAppform() {
            try {
                $query = 'SELECT 
                    student_id,
                    firstname,
                    middlename,
                    lastname,
                    section,
                    course,
                    year,
                    semester,
                    date,
                    gpa 
                FROM ' .$this->appformWaiting. '
                WHERE course = :course 
                AND year = :year
                AND semester = :semester
                AND section = :section';

                $stmt = $this->conn->prepare($query);

                $this->course = htmlspecialchars(strip_tags($this->course));
                $this->year = htmlspecialchars(strip_tags($this->year));
                $this->semester = htmlspecialchars(strip_tags($this->semester));
                $this->section = htmlspecialchars(strip_tags($this->section));

                $stmt->bindParam(':section', $this->section);
                $stmt->bindParam(':course', $this->course);
                $stmt->bindParam(':year', $this->year);
                $stmt->bindParam(':semester', $this->semester);

                $stmt->execute();
                return $stmt;
            } catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function acceptAppformWaiting() {
            try {
                $query = 'INSERT INTO ' . $this->appformApproved . ' (student_id, firstname, middlename, lastname, section, course, year, semester, date, gpa)
                SELECT
                    student_id,
                    firstname,
                    middlename,
                    lastname,
                    section,
                    course,
                    year,
                    semester,
                    date,
                    gpa
                FROM appform
                WHERE student_id = :student_id; 
                DELETE FROM appform
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));

                $stmt->bindParam(':student_id',$this->student_id);

                $stmt->execute();
                return true;
            }

            catch (PDOException $err){
                echo 'failed';
                return false;
            }
        }

        public function declineAppformWaiting() {
            try {
                $query = 'DELETE FROM '.$this->appformWaiting. '
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));

                $stmt->bindParam(':student_id', $this->student_id);

                $stmt->execute();
                return $stmt;
            }

            catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function viewSpecificAppform() {
            try {
                $query = 'SELECT 
                    student_id,
                    firstname,
                    middlename,
                    lastname,
                    section,
                    course,
                    year,
                    semester,
                    date,
                    gpa 
                FROM ' .$this->appformWaiting. '
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));
 
                $stmt->bindParam(':student_id', $this->student_id);

                $stmt->execute();
                return $stmt;
            } 
            catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function viewStudentGrades() {
            try {
                $query = 'SELECT
                    subject_code,
                    subject_name,
                    subject_unit,
                    grade
                FROM ' .$this->gradeTable. '
                WHERE student_id = :student_id';

                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));

                $stmt->bindParam(':student_id', $this->student_id);

                $stmt->execute();
                return $stmt;
            }
            catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }
    }

?>
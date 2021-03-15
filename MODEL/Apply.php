<?php

    class Apply {
        private $conn;
        private $gradeTable = 'grades';
        private $studentTable = 'student';
        private $subjectTable = 'subjects';
        private $appformTable = 'appform';

        public $student_id;
        public $subject_units;
        public $subject_code;
        public $subject_name;
        public $grade;
        public $course;
        public $year;
        public $semester;
        public $section;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function checkStudent() {
            $query = 'SELECT
                student_id
            FROM
            ' . $this->studentTable . '
            WHERE 
                student_id = ?';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->student_id);

            $stmt->execute();
            return $stmt;
        }

        public function checkYearandSemester() {
            $query = 'SELECT
                subject_code,
                subject_name,
                subject_units
            FROM
            ' . $this->subjectTable . '
            WHERE
                course_name = :course AND subject_year = :year AND subject_semester = :semester';
                
            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(':course', $this->course, PDO::PARAM_STR);
            $stmt->bindParam(':year', $this->year, PDO::PARAM_INT);
            $stmt->bindParam(':semester', $this->semester, PDO::PARAM_INT);

            $stmt->execute();   

            return $stmt;
        }

        public function sendGrades() {
            try {
                $query = 'INSERT INTO '. $this->gradeTable . ' (student_id, subject_code, subject_name, grade)
                SELECT 
                    s.student_id, 
                    sub.subject_code, 
                    sub.subject_name,
                    :grade
                FROM student s, subjects sub
                WHERE s.student_id = :student_id
                AND sub.subject_code = :subject_code';
                
                $stmt = $this->conn->prepare($query);

                $this->grade = htmlspecialchars(strip_tags($this->grade));
                $this->student_id = htmlspecialchars(strip_tags($this->student_id));
                $this->subject_code = htmlspecialchars(strip_tags($this->subject_code));

                $stmt->bindParam(':grade',$this->grade);
                $stmt->bindParam(':student_id',$this->student_id);
                $stmt->bindParam(':subject_code',$this->subject_code);

                $stmt->execute();
                return true;
            }

            catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

        public function sendAppform() {
            try {
                $query = 'INSERT INTO ' . $this->appformTable . ' (student_id, firstname, middlename, lastname, section, course, year, semester, date, gpa)
                SELECT
                    s.student_id,
                    s.firstname,
                    s.middlename,
                    s.lastname,
                    :section,
                    :course,
                    :year,
                    :semester,
                    CURDATE(),
                    :gpa
                FROM student s
                WHERE s.student_id = :student_id';
                
                $stmt = $this->conn->prepare($query);

                $this->student_id = htmlspecialchars(strip_tags($this->student_id));
                $this->section = htmlspecialchars(strip_tags($this->section));
                $this->year = htmlspecialchars(strip_tags($this->year));
                $this->course = htmlspecialchars(strip_tags($this->course));
                $this->semester = htmlspecialchars(strip_tags($this->semester));
                $this->gpa = htmlspecialchars(strip_tags($this->gpa));


                $stmt->bindParam(':student_id', $this->student_id);
                $stmt->bindParam(':section', $this->section);
                $stmt->bindParam(':year', $this->year);
                $stmt->bindParam(':course', $this->course);
                $stmt->bindParam(':semester', $this->semester);
                $stmt->bindParam(':gpa', $this->gpa);   

                $stmt->execute();
                return true;
            }
            catch (PDOException $err) {
                echo 'failed';
                return false;
            }
        }

    }

?>
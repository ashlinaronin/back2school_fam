<?php
    // TASK
    class Student {

        private $student_name;
        private $enrollment_date;
        private $course_id;
        private $id;

        function __construct($student_name, $course_id, $enrollment_date = null, $id = null)
        {
            $this->student_name = $student_name;
            $this->enrollment_date = $enrollment_date;
            $this->course_id = $course_id;
            $this->id = $id;
        }

        function getStudentName()
        {
            return $this->student_name;
        }

        function setStudentName($new_student_name)
        {
            $this->student_name = $new_student_name;
        }

        function getEnrollmentDate()
        {
            return $this->enrollment_date;
        }

        function setEnrollmentDate($new_enrollment_date)
        {
            $this->enrollment_date = $new_enrollment_date;
        }

        function getCourseId()
        {
            return $this->course_id;
        }

        // function setCourseId($new_course_id)
        // {
        //     $this->course_id = $new_course_id;
        // }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            try {
                $statement = $GLOBALS['DB']->exec("INSERT INTO students (student_name, enrollment_date, course_id)
                VALUES ('{$this->getStudentName()}', '{$this->getEnrollmentDate()}', {$this->getCourseId()});");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }

        }

        static function getAll()
        {
            try {
                $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }

            $students = array();
            foreach ($returned_students as $student) {
                $student_name = $student['student_name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

    }
?>

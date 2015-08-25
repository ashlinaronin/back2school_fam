<?php
    // TASK
    class Student {

        private $student_name;
        private $enrollment_date;
        private $id;

        function __construct($student_name, $enrollment_date, $id = null)
        {
            $this->student_name = $student_name;
            $this->enrollment_date = $enrollment_date;
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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO students (student_name, enrollment_date, course_id)
                VALUES ('{$this->getStudentName()}', '{$this->getEnrollmentDate()}', {$this->getCourseId()});");
                $result_id = $GLOBALS['DB']->lastInsertId();
                $this->setId($result_id);
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
                $course_id = $student['course_id'];
                $id = $student['id'];
                $new_student = new Student($student_name, $enrollment_date, $course_id, $id);
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

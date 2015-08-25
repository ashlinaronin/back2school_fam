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
                $GLOBALS['DB']->exec("INSERT INTO students (student_name, enrollment_date) VALUES (
                    '{$this->getStudentName()}',
                    '{$this->getEnrollmentDate()}'
                );");
                $this->id = $GLOBALS['DB']->lastInsertId();
                } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }


        // These two methods require the join table
        function addCourse($course)
        {

        }
        function getCourses()
        {

        }



        function updateName($new_name)
        {

        }

        function delete()
        {

        }


        static function getAll()
        {
            try {
                $students_query = $GLOBALS['DB']->query("SELECT * FROM students;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }

            $all_students = array();
            foreach ($students_query as $student) {
                $student_name = $student['student_name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($student_name, $enrollment_date, $id);
                array_push($all_students, $new_student);
            }
            return $all_students;
        }

        static function find($search_id)
        {
            $found_student = null;
            $all_students = Student::getAll();
            foreach ($all_students as $student) {
                if ($student->getId() == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

    }
?>

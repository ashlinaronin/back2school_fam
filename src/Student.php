<?php

    class Student {

        private $name;
        private $enrollment_date;
        private $department_id;
        private $id;

        function __construct($name, $enrollment_date, $department_id = null, $id = null)
        {
            $this->name = $name;
            $this->enrollment_date = $enrollment_date;
            $this->department_id = $department_id;
            $this->id = $id;
        }

        function getStudentName()
        {
            return $this->name;
        }

        function setStudentName($new_name)
        {
            $this->name = $new_name;
        }

        function getEnrollmentDate()
        {
            return $this->enrollment_date;
        }

        function getDepartmentId()
        {
            return $this->department_id;
        }

        function setDepartmentId($new_department_id)
        {
            $this->department_id = $new_department_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment_date, department_id) VALUES (
                    '{$this->getStudentName()}',
                    '{$this->getEnrollmentDate()}',
                    {$this->getDepartmentId()}
                );");
                $this->id = $GLOBALS['DB']->lastInsertId();
                } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }


        // These two methods require the join table
        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO enrollments (student_id, course_id) VALUES(
                {$this->getId()},
                {$course->getId()}
            );");
        }
        function getCourses()
        {
            $courses_query = $GLOBALS['DB']->query(
                "SELECT courses.* FROM
                    students JOIN enrollments ON (enrollments.student_id = students.id)
                             JOIN courses     ON (enrollments.course_id  = courses.id)
                 WHERE students.id = {$this->getId()};
                "
            );
            $matching_courses = array();
            foreach ($courses_query as $course) {
                $name = $course['name'];
                $code = $course['code'];
                $department_id = $course['department_id'];
                $id = $course['id'];
                $new_course = new Course($name, $code, $department_id, $id);
                array_push($matching_courses, $new_course);
            }
            return $matching_courses;
        }



        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setStudentName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM enrollments WHERE student_id = {$this->getId()};");
        }


        // Completed course methods
        function updateCompleted($course_id)
        {
            $GLOBALS['DB']->exec("UPDATE enrollments SET completed = 1 WHERE student_id = {$this->getId()} AND course_id = {$course_id};");
        }

        function getCompleted($course_id)
        {
            $completed_query = $GLOBALS['DB']->query("SELECT * FROM enrollments WHERE student_id = {$this->getId()} AND course_id = {$course_id};");
            $garbage = array();
            foreach ($completed_query as $row) {
                array_push($garbage, $row['completed']);
            }
            if ($garbage[0] == 1) {
                return true;
            } else {
                return false;
            }
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
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $department_id = $student['department_id'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $department_id, $id);
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
            $GLOBALS['DB']->exec("DELETE FROM enrollments;");
        }

    }
?>

<?php

    class Course
    {
        private $name;
        private $code;
        private $department_id;
        private $id;

        function __construct($name, $code, $department_id = null, $id = null)
        {
            $this->name = $name;
            $this->code = $code;
            $this->department_id = $department_id;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setCode($new_code)
        {
            $this->code = (string) $new_code;
        }

        function getCode()
        {
            return $this->code;
        }

        function getDepartmentId()
        {
            return $this->department_id;
        }

        function setDepartmentId($new_id)
        {
            $this->department_id = $new_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO courses (name, code, department_id) VALUES (
                    '{$this->getName()}',
                    '{$this->getCode()}',
                    {$this->getDepartmentId()}
                );");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM enrollments WHERE course_id = {$this->getId()};");
        }

        function getStudents()
        {
            $students_query = $GLOBALS['DB']->query(
                "SELECT students.* FROM
                    courses JOIN enrollments ON (enrollments.course_id = courses.id)
                            JOIN students    ON (enrollments.student_id = students.id)
                 WHERE courses.id = {$this->getId()};
                "
            );
            $matching_students = array();
            foreach ($students_query as $student) {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $department_id = $student['department_id'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $department_id, $id);
                array_push($matching_students, $new_student);
            }
            return $matching_students;
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO enrollments (student_id, course_id) VALUES(
                {$student->getId()},
                {$this->getId()}
            );");
        }

        static function getAll()
        {
            try {
                $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
            $courses = array();
            foreach ($returned_courses as $course) {
                $name = $course['name'];
                $code = $course['code'];
                $department_id = $course['department_id'];
                $id = $course['id'];
                $new_course = new Course($name, $code, $department_id, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
            $GLOBALS['DB']->exec("DELETE FROM enrollments;");
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach ($courses as $course) {
                if ($course->getId() == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }
    }
?>

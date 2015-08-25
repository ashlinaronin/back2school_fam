<?php

    class Course
    {
        private $name;
        private $code;
        private $id;

        function __construct($name, $code, $id = null)
        {
            $this->name = $name;
            $this->code = $code;
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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO courses (name, code) VALUES (
                    '{$this->getName()}',
                    '{$this->getCode()}'
                );");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        function updateName($new_name)
        {

        }

        function delete()
        {

        }

        function getStudents()
        {

        }

        function addStudent($student)
        {

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
                $id = $course['id'];
                $new_course = new Course($name, $code, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
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

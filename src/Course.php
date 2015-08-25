<?php

    class Course
    {
        private $course_name;
        private $course_number;
        private $id;

        function __construct($course_name, $course_number, $id = null)
        {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        function setCourseName($new_course_name)
        {
            $this->course_name = (string) $new_course_name;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = (string) $new_course_number;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        function save()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number)
                VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
                $result_id = $GLOBALS['DB']->lastInsertId();
                $this->setId($result_id);
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
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
                $course_name = $course['course_name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($course_name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function find($searchId)
        {

        }

    }
?>

<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function testGetId()
        {
           //Arrange
           $course_name = "History 0001";
           $course_number = "HS0001";
           $id = 1;
           $test_Course = new Course($course_name, $course_number, $id);

           //Act
           $result = $test_Course->getId();

           //Assert
           $this->assertEquals(true, is_numeric($result));
       }

        function testSave()
        {
            //Arrange
            $course_name = "History 0001";
            $course_number = "HS001";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $course_name = "History 0001";
            $course_number = "HS001";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();

            $course_name2 = "Dogs 101";
            $course_number2 = "DW101";
            $test_course2 = new Course($course_name2, $course_number2);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }
    }



?>

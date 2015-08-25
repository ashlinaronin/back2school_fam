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

        function test_getName()
        {
           //Arrange
           $name = "History 0001";
           $code = "HS0001";
           $test_course = new Course($name, $code);

           //Act
           $result = $test_course->getName();

           //Assert
           $this->assertEquals($name, $result);
       }

        function test_save()
        {
            //Arrange
            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code);
            $test_course->save();

            $name2 = "Dogs 101";
            $code2 = "DW101";
            $test_course2 = new Course($name2, $code2);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        // find test
        function test_find()
        {
            //Arrange
            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code);
            $test_course->save();

            $name2 = "Dogs 101";
            $code2 = "DW101";
            $test_course2 = new Course($name2, $code2);
            $test_course2->save();

            //Act
            $result = Course::find($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }

        //update test
        function test_updateName()
        {
           //Arrange
           $name = "History 0001";
           $code = "HS0001";
           $test_course = new Course($name, $code);

           //Act
           $new_name = "Da Constitutia";
           $test_course->updateName($new_name);

           //Assert
           $this->assertEquals($new_name, $test_course->getName());
       }

        //delete test
        function test_delete()
        {
            //Arrange
            $name = "History 0001";
            $code = "HS001";
            $test_course = new Course($name, $code);
            $test_course->save();

            $name2 = "Dogs 101";
            $code2 = "DW101";
            $test_course2 = new Course($name2, $code2);
            $test_course2->save();

            //Act
            $test_course->delete();

            //Assert
            $result = Course::getAll();
            $this->assertEquals($test_course2, $result[0]);
        }

        //add student and get students tests together
     }



?>

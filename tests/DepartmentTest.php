<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";
    require_once "src/Course.php";
    require_once "src/Department.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class DepartmentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Student::deleteAll();
            Course::deleteAll();
            Department::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Biology";
            $address = "346 Stupid Avenue";
            $test_department = new Department($name, $address);
        }


    }



?>

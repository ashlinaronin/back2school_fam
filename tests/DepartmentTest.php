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

            //Act
            $result = $test_department->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Biology";
            $address = "346 Stupid Avenue";
            $test_department = new Department($name, $address);

            //Act
            $test_department->save();

            //Assert
            $result = Department::getAll();
            $this->assertEquals($test_department, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Biology";
            $address = "346 Stupid Avenue";
            $test_department = new Department($name, $address);
            $test_department->save();

            $name2 = "Chemiology";
            $address2 = "55 Bo Ct";
            $test_department2 = new Department($name2, $address2);
            $test_department2->save();

            //Act
            $result = Department::getAll();

            //Assert
            $this->assertEquals([$test_department, $test_department2], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Biology";
            $address = "346 Stupid Avenue";
            $test_department = new Department($name, $address);
            $test_department->save();

            $name2 = "Chemiology";
            $address2 = "55 Bo Ct";
            $test_department2 = new Department($name2, $address2);
            $test_department2->save();

            //Act
            $result = Department::find($test_department2->getId());

            //Assert
            $this->assertEquals($test_department2, $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Biology";
            $address = "346 Stupid Avenue";
            $test_department = new Department($name, $address);
            $test_department->save();

            $name2 = "Chemiology";
            $address2 = "55 Bo Ct";
            $test_department2 = new Department($name2, $address2);
            $test_department2->save();

            //Act
            $new_name = "Cancer Studies aka Oncology";
            $test_department->updateName($new_name);

            //Assert
            $result = Department::getAll();
            $this->assertEquals($new_name, $result[0]->getName());
        }

        function test_delete()
        {
            //Arrange
            $name = "Biology";
            $address = "346 Stupid Avenue";
            $test_department = new Department($name, $address);
            $test_department->save();

            $name2 = "Chemiology";
            $address2 = "55 Bo Ct";
            $test_department2 = new Department($name2, $address2);
            $test_department2->save();

            //Act
            $test_department->delete();

            //Assert
            $result = Department::getAll();
            $this->assertEquals([$test_department2], $result);
        }


    }



?>

<?php
    class Department
    {
        private $name;
        private $address;
        private $id;

        function __construct($name, $address, $id = null)
        {
            $this->name = $name;
            $this->address = $address;
            $this->id = $id;
        }


        //getters and setters
        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getAddress()
        {
            return $this->address;
        }

        function setAddress($new_address)
        {
            $this->address = $new_address;
        }

        function getId()
        {
            return $this->id;
        }



        //database jawns
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO departments (name, address) VALUES (
                '{$this->getName()}',
                '{$this->getAddress()}'
            );");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE departments SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments WHERE id = {$this->getId()};");
            // deal with students and courses that now are missing a department?
            // not now
        }


        //get other classes
        function getStudents()
        {

        }

        function getCourses()
        {

        }

        static function getAll()
        {
            $departments_query = $GLOBALS['DB']->query("SELECT * FROM departments;");
            $all_departments = array();
            foreach ($departments_query as $department) {
                $name = $department['name'];
                $address = $department['address'];
                $id = $department['id'];
                $new_department = new Department($name, $address, $id);
                array_push($all_departments, $new_department);
            }
            return $all_departments;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments;");
        }

        static function find($search_id)
        {
            $found_department = null;
            $all_deps = Department::getAll();
            foreach ($all_deps as $dep) {
                if ($dep->getId() == $search_id) {
                    $found_department = $dep;
                }
            }
            return $found_department;
        }
    }

?>

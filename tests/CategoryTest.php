<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    **/

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName()
        {
            // Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);
            // Act
            $result = $test_Category->getName();
            // Assert
            $this->assertEquals($name, $result);
        }

        function test_save()
        {
            // Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            // Act
            $result = Category::getAll();
            // Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            // Act
            $result = Category::getAll();
            // Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            // Act
            Category::deleteAll();
            $result = Category::getAll();
            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            // Act
            $result = Category::find($test_Category->getId());
            // Assert
            $this->assertEquals($test_Category, $result);
        }

        function test_getTasks()
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $test_category_id = $test_category->getId();

            $description = "Email client";
            $test_task = new Task($description, $id, $test_category_id);
            $test_task->save();

            $description2 = "Meet with boss";
            $test_task2 = new Task($description2, $id, $test_category_id);
            $test_task2->save();

            //Act
            $result = $test_category->getTasks();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }
    }
 ?>

<?php

/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
	require_once 'src/Author.php';

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
	class AuthorTest extends PHPUnit_Framework_TestCase
	{

        protected function tearDown()
		{
			Author::deleteAll();
		}

        function testGetName()
        {
            //Arrange
            $name = "John Steinbeck";
            $test_author = new Author($id = null, $name);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "John Steinbeck";
            $test_author = new Author($id = null, $name);

            //Act
            $test_author->setName('Cormac M');
            $result = $test_author->getName();

            //Assert
            $this->assertEquals('Cormac M', $result);

        }

        function testGetId()
        {
            //Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(1, $result);

        }

        function testSave()
        {
            //Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();


            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function testUpdateName()
        {
            //Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            //Act
            $test_author->updateName('Cucumber');
            //Assert
            $this->assertEquals('Cucumber', $test_author->getName());
        }

        function testFind()
        {
            //Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            //Act
            $result = Author::find($test_author->getId());

            //Arrange
            $this->assertEquals($test_author, $result);
        }

        function testDelete()
		{//delete one course
			//Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            $name2 = "Dr. Suess";
            $id2 = 2;
            $test_author2 = new Author($id2, $name2);
            $test_author2->save();
			//Act
			$test_author->delete();
			$result = Author::getAll();
			//Assert
			$this->assertEquals([$test_author2], $result);
		}

    }


?>

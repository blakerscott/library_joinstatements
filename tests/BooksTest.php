<?php

/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
	require_once 'src/Book.php';
    require_once 'src/Author.php';


    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
	class BookTest extends PHPUnit_Framework_TestCase
	{

        protected function tearDown()
		{
			Book::deleteAll();
            Author::deleteAll();
		}

        function testGetTitle()
        {
            //Arrange
            $title = "Harry Potter";
            $test_book = new Book($id = null, $title);
            //Act
            $result = $test_book->getTitle();
            //Assert
            $this->assertEquals($title, $result);
        }

		function testSetTitle()
		{

            $title = "Harry Potter";
            $test_book = new Book($id = null, $title);

            //Act
            $test_book->setTitle("Harry Potter III");
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals('Harry Potter III', $result);

		}
		function testGetId()
		{
            //Arrange
            $title = "Harry Potter";
            $id = 1;
            $test_book = new Book($id, $title);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(1, $result);

		}

		function testSave()
		{
			//Arrange
            $title = "Harry Potter";
            $id = null;
            $test_book = new Book($id, $title);
			$test_book->save();


			//Act
			$result = Book::getAll();

			//Assert
			$this->assertEquals([$test_book], $result);
		}

		function testGetAll()
		{

            //Arrange
            $title = "Harry Potter";
            $id = 1;
            $test_book = new Book($id, $title);
			$test_book->save();

            $title2 = "Tortilla Flat";
            $id2 = 2;
            $test_book2 = new Book($id2, $title2);
            $test_book2->save();

			//Act
			$result = Book::getAll();

			//Assert
			$this->assertEquals([$test_book, $test_book2], $result);
		}

		function testDeleteAll()
		{
			//Arrange
            $title = "Harry Potter";
            $id = null;
            $test_book = new Book($id, $title);
			$test_book->save();

            $title2= "Tortilla Flat";
            $test_book2 = new Book($id, $title2);
            $test_book2->save();

			//Act
			Book::deleteAll();
			$result = Book::getAll();
			//Assert
			$this->assertEquals([], $result);
		}

		function testUpdateTitle()
		{
			//Arrange
            $title = "Harry Pooper";
            $id = null;
            $test_book = new Book($id, $title);
			$test_book->save();

			//Act
			$test_book->updateTitle('Harry Potter');
			//Assert
			$this->assertEquals('Harry Potter', $test_book->getTitle());
		}

		function testFind()
		{
			//Arrange
            $title = "Harry Potter";
            $id = null;
            $test_book = new Book($id, $title);
			$test_book->save();

			//Act
			$result = Book::find($test_book->getId());
			//Arrange
			$this->assertEquals($test_book, $result);
		}

		function testDelete()
		{//delete one course
			//Arrange
            $title = "Harry Potter";
            $id = 1;
            $test_book = new Book($id, $title);
			$test_book->save();

            $title2= "Tortilla Flat";
            $id2 = 2;
            $test_book2 = new Book($id2, $title2);
            $test_book2->save();
			//Act
			$test_book->delete();
			$result = Book::getAll();
			//Assert
			$this->assertEquals([$test_book2], $result);
		}

        function testAddAuthor()
        {
            //Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            $title = "Grapes of Wrath";
            $id2 = 5;
            $test_book = new Book($id2, $title);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $this->assertEquals($test_book->getAuthor(), [$test_author]);

        }

        function testGetAuthor()
        {
            //Arrange
            $name = "John Steinbeck";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            $name2 = "Jane Steinbeck";
            $id2 = 2;
            $test_author2 = new Author($id2, $name2);
            $test_author2->save();

            $title = "Short Stories by Author";
            $id2 = 5;
            $test_book = new Book($id2, $title);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //Assert
            $this->assertEquals($test_book->getAuthor(), [$test_author, $test_author2]);


        }

///workspace




	}
?>

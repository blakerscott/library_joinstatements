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
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
            //Act
            $result = $test_book->getTitle();
            //Assert
            $this->assertEquals($title, $result);
        }

		function testSetTitle()
		{

            //Arrange
            $title = "Harry Potter";
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);

            //Act
            $test_book->setTitle("Harry Potter III");
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals('Harry Potter III', $result);

		}
		function testGetId()
		{
            //Arrange
            $id = 1;
            $title = "Harry Potter";
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id, $title, $copies_total, $copies_available);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(1, $result);

		}

		function testSave()
		{
            //Arrange
            $title = "Harry Potter";
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
            $test_book->save();

            $title2 = "Harry P";
            $copies_total2 = 3;
            $copies_available2 = 2;
            $test_book2 = new Book($id = null, $title2, $copies_total2, $copies_available2);
            $test_book2->save();

            //Act
			$result = Book::getAll();

			//Assert
			$this->assertEquals([$test_book, $test_book2], $result);
		}

		function testGetAll()
		{

            //Arrange
            $title = "Harry Potter";
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
            $test_book->save();

            $title2 = "Harry P";
            $copies_total2 = 3;
            $copies_available2 = 2;
            $test_book2 = new Book($id = null, $title2, $copies_total2, $copies_available2);
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
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
            $test_book->save();

            $title2 = "Harry P";
            $copies_total2 = 3;
            $copies_available2 = 2;
            $test_book2 = new Book($id = null, $title2, $copies_total2, $copies_available2);
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
            $title = "Harry Popper";
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
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
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
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
            $copies_total = 10;
            $copies_available = 2;
            $test_book = new Book($id = null, $title, $copies_total, $copies_available);
            $test_book->save();

            $title2 = "Harry P";
            $copies_total2 = 3;
            $copies_available2 = 2;
            $test_book2 = new Book($id = null, $title2, $copies_total2, $copies_available2);
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
            $name = "JK Rowling";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            $title = "Harry Potter";
            $copies_total = 10;
            $copies_available = 2;
            $id2 = 2;
            $test_book = new Book($id2, $title, $copies_total, $copies_available);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);
			$result = $test_book->getAuthor();

            //Assert
            $this->assertEquals('JK Rowling', $result);

        }

        function testGetAuthor()
        {
            //Arrange
            $name = "JK Rowling";
            $id = 1;
            $test_author = new Author($id, $name);
            $test_author->save();

            $name2 = "JK Rowlings Ghost Writer";
            $id2 = 2;
            $test_author2 = new Author($id2, $name2);
            $test_author2->save();

            $title = "Harry Potter";
            $copies_total = 10;
            $copies_available = 2;
            $id3 = 2;
            $test_book = new Book($id3, $title, $copies_total, $copies_available);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);
			$result = $test_book->getAuthor();

            //Assert
            $this->assertEquals('JK Rowling, JK Rowlings Ghost Writer', $result);


        }

///workspace




	}
?>

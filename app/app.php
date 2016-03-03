<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";


    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    use Symfony\Component\Debug\Debug;
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));
 // instantiate Silex app, add twig capability to app


    $app->get("/", function() use ($app) {
        //home page
        return $app['twig']->render('index.html.twig');
    });

    //////Books/////////////
    ////////////////////////

    $app->get("/admin", function() use ($app) {
        //Get all books
        return $app['twig']->render('admin.html.twig', array(
            'books' => Book::getAll(),
            'authors' => Author::getAll()
        ));
    });

    $app->get("/book/{id}", function($id) use ($app) {
        //Navigate to a specific edit/update page
        $book = Book::find($id);
        return $app['twig']->render('editbook.html.twig', array(
            'authors' => Author::getAll(),
            'book' => $book
        ));
    });

    $app->patch("/update_book/{id}", function($id) use ($app) {
        //Route for when you click on update book button
        $new_title = $_POST['title'];
        $book = Book::find($id);
        $book->updateTitle($new_title);
        return $app['twig']->render('admin.html.twig', array(
            'book' => $book,
            'books' => Book::getAll(),
            'authors' => Author::getAll()
        ));
    });



    $app->post("/admin_add_book", function() use ($app) {
        //Add a book to the database
        $title = $_POST['title'];
        $copies_total = $_POST['copies_total'];
        $copies_available = $_POST['copies_total'];
        $book = new Book($id = null, $title, $copies_total, $copies_available);
        $book->save();
        return $app['twig']->render('admin.html.twig', array(
            'authors' => Author::getAll(),
            'books' => Book::getAll()
        ));
    });

    $app->delete('/delete_all_books', function() use ($app) {
		//Nuke all books
		Book::deleteAll();
		return $app['twig']->render('admin.html.twig', array(
            'authors' => Author::getAll(),
			'books' => Book::getAll()
	  ));
	});

    $app->delete('/delete_this_book/{id}', function($id) use ($app) {
		//Delete a single book
        $book = Book::find($id);
        $book->delete();
		return $app['twig']->render('admin.html.twig', array(
            'authors' => Author::getAll(),
			'books' => Book::getAll()
	  ));
	});

    //////Author/////////////
    ////////////////////////

    $app->post('/admin_add_author', function() use ($app) {
        //adds an author Yay
        $name = $_POST['author'];
        $author = new Author($id = null, $name);
        $author->save();
        return $app['twig']->render('admin.html.twig', array(
            'books' => Book::getAll(),
            'authors' => Author::getAll()
        ));
    });


    return $app;
?>

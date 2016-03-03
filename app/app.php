<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));
 // instantiate Silex app, add twig capability to app


    $app->get("/", function() use ($app) {
        //home page
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/admin", function() use ($app) {
        return $app['twig']->render('admin.html.twig', array(
            'books' => Book::getAll()
        ));
    });

    $app->post("/admin_add_book", function() use ($app) {
        $title = $_POST['title'];
        $copies_total = $_POST['copies_total'];
        $copies_available = $_POST['copies_total'];
        $book = new Book($id = null, $title, $copies_total, $copies_available);
        $book->save();
        return $app['twig']->render('admin.html.twig', array(
            'books' => Book::getAll()
        ));
    });

    $app->delete('/delete_all_books', function() use ($app) {
		//deletes all courses
		Book::deleteAll();
		return $app['twig']->render('admin.html.twig', array(
			'books' => Book::getAll(),
	  ));
	});


    return $app;
?>

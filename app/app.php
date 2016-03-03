<?php
    require_once __DIR__."/../vendor/autoload.php";
    // require_once __DIR__."/../src/MyClass.php";

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
        //admin page
        return $app['twig']->render('admin.html.twig');
    });

    return $app;
?>

<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylist' =>
        Stylist::getAll()));
    });

    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['stylist_name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylist' => Stylist::getAll()));
    });

    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();
    return $app['twig']->render('index.html.twig', array('stylist' => Stylist::getAll()));
    });

    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/clients", function() use ($app){
        $client_name = $_POST['client_name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($_POST['client_name'], $id = null, $stylist_id);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/delete_clients", function() use ($app){
        Client::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylist' => Stylist::getAll()));
    });












    //
    // $app->get("/restaurants/{id}/edit", function($id) use ($app) {
    //     // $restaurant = new Restaurant($_POST['name'], $id = null, $cuisine_id, $_POST['price_range'], $_POST['neighborhood']);
    //     $restaurant = Restaurant::find($id);
    //     return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant));
    // });
    //
    // $app->patch("/restaurants/{id}", function($id) use ($app) {
    //     $name = $_POST['name'];
    //     $price_range = $_POST['price_range'];
    //     $neighborhood = $_POST['neighborhood'];
    //     $restaurant = Restaurant::find($id);
    //     $restaurant->updateName($name);
    //     $restaurant->updatePriceRange($price_range);
    //     $restaurant->updateNeighborhood($neighborhood);
    //     return $app['twig']->render('cuisine.html.twig', array('cuisines' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    // });

    return $app;

?>

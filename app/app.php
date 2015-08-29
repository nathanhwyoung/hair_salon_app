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
        return $app['twig']->render('index.html.twig', array(
          'stylist' => Stylist::getAll()));
    });

    $app->post("/stylist", function() use ($app) {
        $stylist = new Stylist($_POST['stylist_name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array(
          'stylist' => Stylist::getAll()));
    });

    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig', array(
      'stylist' => Stylist::getAll()));
    });

    $app->get("/stylist/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    $app->get("/stylist/{id}/edit/", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    $app->post("/clients", function() use ($app){
        $client_name = $_POST['client_name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($_POST['client_name'], $id = null, $stylist_id);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    $app->patch("/stylists/{id}", function($id) use ($app) {
        $new_stylist_name = $_POST['new_stylist_name'];
        $stylist = Stylist::find($id);
        $stylist->updateStylistName($new_stylist_name);
        return $app['twig']->render('index.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    $app->post("/delete_clients", function() use ($app){
        Client::deleteAll();
        return $app['twig']->render('index.html.twig', array(
          'stylist' => Stylist::getAll()));
    });

    $app->delete("/stylist/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array(
          'stylist' => $stylist));
    });

    $app->patch("/stylist/{id}", function($id) use ($app) {
        $new_stylist_name = $_POST['new_stylist_name'];
        $stylist = Stylist::find($id);
        $stylist->updateStylistName($new_stylist_name);
        return $app['twig']->render('stylist.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    $app->get("/client/{id}/edit", function($id) use ($app) {
        $client = Client::find($id);
        return $app['twig']->render('client_edit.html.twig', array(
          'client' => $client));
    });

    $app->patch("/client/{id}", function($id) use ($app) {
        $new_client_name = $_POST['new_client_name'];
        $client = Client::find($id);
        $client->updateClientName($new_client_name);
        $stylist_id = $client->getStylistId();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    $app->delete("/client/{id}", function($id) use ($app) {
        $client = Client::find($id);
        $client->delete();
        $stylist_id = $client->getStylistId();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array(
          'stylist' => $stylist,
          'clients' => $stylist->getClients()));
    });

    return $app;

?>

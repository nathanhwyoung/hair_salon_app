<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_getId()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;

            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();

            //act
            $result = $test_client->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;

            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();

            //act
            $result = $test_client->getStylistId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);

            //act
            $test_client->save();

            //assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();

            $client_name2 = "Ludacris";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($client_name2, $id, $stylist_id);
            $test_client2->save();

            //act
            $result = Client::getAll();

            //assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);

            $client_name2 = "Ludacris";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($client_name2, $id, $stylist_id);

            //act
            Client::deleteAll();

            //assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();

            $client_name2 = "Ludacris";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($client_name2, $id, $stylist_id);
            $test_client2->save();


            //act
            $id = $test_client->getId();
            $result = Client::find($id);

            //assert
            $this->assertEquals($test_client, $result);
        }

        function test_updateClientName()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);

            $new_client_name = "Steven";

            //act
            $test_client->updateClientName($new_client_name);

            //assert
            $this->assertEquals("Steven", $test_client->getClientName());
        }

        function test_delete()
        {
            //arrange
            $stylist_name = "Lisa";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Alfred";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();


            $client_name2 = "Ludacris";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($client_name2, $id, $stylist_id);
            $test_client2->save();


            $test_client->delete();

            //assert
            $this->assertEquals([$test_client2], Client::getAll());
        }
    }

?>

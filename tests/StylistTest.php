<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getStylistName()
        {
            //arrange
            $stylist_name = "Agnes";
            $test_stylist = new Stylist($stylist_name);

            //act
            $result = $test_stylist->getStylistName();

            //assert
            $this->assertEquals($stylist_name, $result);
        }

        function test_getId()
        {
            //arrange
            $stylist_name = "Agnes";
            $id = 1;
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            //act
            $result = $test_stylist->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //arrange
            $stylist_name = "Agnes";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            //act
            $result = Stylist::getAll();

            //assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $stylist_name = "Agnes";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            $stylist_name2 = "Cathy";
            $test_stylist2 = new Stylist($stylist_name2);
            $test_stylist2->save();

            //act
            $result = Stylist::getAll();

            //assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);

        }

        function test_deleteAll()
        {
            //arrange
            $stylist_name = "Agnes";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            $stylist_name2 = "Cathy";
            $test_stylist2 = new Stylist($stylist_name2);
            $test_stylist2->save();

            //act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //arrange
            $stylist_name = "Agnes";
            $test_stylist = new Stylist($stylist_name);
            $test_stylist->save();

            $stylist_name2 = "Cathy";
            $test_stylist2 = new Stylist($stylist_name2);
            $test_stylist2->save();

            //act
            $result = Stylist::find($test_stylist2->getId());

            //assert
            $this->assertEquals($test_stylist2, $result);
        }

        function test_update()
        {
            //arrange
            $stylist_name = "Nora";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $new_stylist_name = "Dora";

            //act
            $test_stylist->updateStylistName($new_stylist_name);

            //assert
            $this->assertEquals("Dora", $test_stylist->getStylistName());
        }

        function test_delete()
        {
            //arrange
            $stylist_name = "Nora";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $stylist_name2 = "Andrea";
            $test_stylist2 = new Stylist($stylist_name2, $id);
            $test_stylist2->save();

            //act
            $test_stylist->delete();

            //assert
            $this->assertEquals([$test_stylist2], Stylist::getAll());

        }
    }

 ?>

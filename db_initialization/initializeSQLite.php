<?php
  try
  {
    //open the database
    $db = new PDO('sqlite:BlogDb_PDO.sqlite');

    //create the database
    $db->exec("CREATE TABLE BlogPosts (Id INTEGER PRIMARY KEY, Category TEXT, Author TEXT, ActualPost TEXT)");    

    //insert some data...
    $db->exec("INSERT INTO BlogPosts (Category, Author, ActualPost) VALUES ('Vacataion','Admin','sa va povestesc cum a fost in vacanta, super aventuri am trait');".
               "INSERT INTO BlogPosts (Category, Author, ActualPost) VALUES ('Amuzante', 'SpecialGuest', 'De cati politisti e nevoie sa insurubezi un bec'); " );
               
    //now output the data to a simple html table...
    print "<table border=1>";
    print "<tr><td>Id</td><td>Breed</td><td>Name</td><td>Age</td></tr>";
    $result = $db->query('SELECT * FROM BlogPosts');
    foreach($result as $row)
    {
      print "<tr><td>".$row['Id']."</td>";
      print "<td>".$row['Category']."</td>";
      print "<td>".$row['Author']."</td>";
      print "<td>".$row['ActualPost']."</td></tr>";
    }
    print "</table>";

    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
?>
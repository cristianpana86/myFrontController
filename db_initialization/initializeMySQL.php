<?php
    $user='myblog';
    $pass='password';
try{
            
    $db = new PDO('mysql:host=localhost;dbname=myblog', $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //create the database
       $db->exec("CREATE TABLE blogposts (Id INTEGER NOT NULL AUTO_INCREMENT, Category varchar(255), Author varchar(255), ActualPost TEXT,PRIMARY KEY(Id))ENGINE=MyISAM;");
       $db->exec("create table static_pages(id INTEGER NOT NULL AUTO_INCREMENT, textcontent text, photourl text, PRIMARY KEY (id) );");

    //insert some data...
    $db->exec(
        "INSERT INTO BlogPosts (Category, Author, ActualPost) VALUES ('Vacataion','Admin','sa va povestesc cum a fost in vacanta, super aventuri am trait');".
        "INSERT INTO BlogPosts (Category, Author, ActualPost) VALUES ('Amuzante', 'SpecialGuest', 'De cati politisti e nevoie sa insurubezi un bec'); " 
    );
                   
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
    $db = null;
    
}
catch(PDOException $e)
{
    print 'Exception : '.$e->getMessage();
}
?>

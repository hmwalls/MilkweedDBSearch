<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1">
    <title>Search  Contacts</title>
  </head>
  <p><body>
    <h3>Search</h3>
    <p>You  may search either by first or last name</p>
    <form  method="post" action="search.php?go"  id="searchform">
      <input  type="text" name="name">
      <input  type="submit" name="submit" value="Search">
    </form>
  <?php
  if(isset($_POST['submit'])){
  if(isset($_GET['go'])){
  if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){
  $name=$_POST['name'];
  //connect  to the database
  $db=mysql_connect  ("localhost", "hailey",  "b0Mbu$") or die ('I cannot connect to the database  because: ' . mysql_error());
  //-select  the database to use
  $mydb=mysql_select_db("milkweed");
  //-query  the database table
  $sql="Select Commonname, scientificname, databasecode, name, state, zip, url, email, phone, notes, seed, liveplant FROM availability JOIN plants ON availability.plant_ID = plants.plant_ID Join sources ON availability.source_ID = sources.source_ID;";
  //-run  the query against the mysql query function
  $result=mysql_query($sql);
  //-create  while loop and loop through result set
  while($row=mysql_fetch_array($result)){
          $Commonname  =$row['Commonname'];
          $scientificname=$row['scientificname'];
          $name=$row['name'];
  //-display the result of the array
  echo "<ul>\n";
  echo "<li>" . "<a  href=\"search.php?id=$ID\">"   .$Commonname . " " . $scientificname .  "</a></li>\n";
  echo "</ul>";
  }
  }
  else{
  echo  "<p>Please enter a search query</p>";
  }
  }
  }
?>
  </body>
</html>
</p>
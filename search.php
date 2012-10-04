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
      <input  type="text" name="databasecodeentry">
      <input  type="submit" name="submit" value="Search by Plant Database Code">
    </form>
    <form  method="post" action="search.php?go"  id="searchform">
      <input  type="text" name="stateentry">
      <input  type="submit" name="submit" value="Search State">
    </form>

  <?php
  if(isset($_POST['submit'])){
  if(isset($_GET['go'])){
  if(preg_match("/^[  a-zA-Z0-9]+/", $_POST['databasecodeentry'])){
  $databasecodeentry=$_POST['databasecodeentry'];
  //connect  to the database
  $db=mysql_connect  ("localhost", "hailey",  "b0Mbu$") or die ('I cannot connect to the database  because: ' . mysql_error());
  //-select  the database to use
  $mydb=mysql_select_db("milkweed");
  //-query  the database table
  $sql="Select Commonname, scientificname, databasecode, name, state, zip, url, email, phone, notes, seed, liveplant FROM availability JOIN plants ON availability.plant_ID = plants.plant_ID Join sources ON availability.source_ID = sources.source_ID WHERE databasecode like '$databasecodeentry%'";
  //-run  the query against the mysql query function
  $result=mysql_query($sql);
  //-create  while loop and loop through result set
  while($row=mysql_fetch_array($result)){
          $Commonname  =$row['Commonname'];
          $scientificname=$row['scientificname'];
          $name=$row['name'];
          $databasecode=$row['databasecode'];
          $state=$row['state'];
          $zip=$row['zip'];
          $url=$row['url'];
          $email=$row['email'];
          $phone=$row['phone'];
          $notes=$row['notes'];
          $seed=$row['seed'];
          $liveplant=$row['liveplant'];
  //-display the result of the array
  echo "<table border=1>\n";
  echo "<tr> <td> $liveplant </td> <td> $seed </td> <td> $Commonname </td> <td> $scientificname </td> <td> $databasecode </td> <td> $name </td> <td> $state </td> <td> $zip </td> <td> $url </td> <td> $email </td> <td> $phone </td> <td> $notes </td> </tr>\n";
  echo "</table>";
  echo "$databasecodeentry";
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
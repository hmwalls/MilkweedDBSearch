<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Search Contacts</title>
  </head>

  <body>
    <h3>Search For Native Milkweed</h3>
    <form method="post" action="search.php?go" id="searchform"> <br>
      Plant Database Code: <input type="text" name="databasecodeentry"><br>
      Common Name: <input type="text" name="commonnameentry"><br>
      Scientific Name: <input type="text" name="scientificnameentry"><br>
      ZIP Code: <input type="text" name="zipcodeentry"><br>
      State: <select name="stateentry">
        <option value="">Any State</option>
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District of Columbia</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
        <option value="IA">Iowa</option>
        <option value="KS">Kansas</option>
        <option value="KY">Kentucky</option>
        <option value="LA">Louisiana</option>
        <option value="ME">Maine</option>
        <option value="MD">Maryland</option>
        <option value="MA">Massachusetts</option>
        <option value="MI">Michigan</option>
        <option value="MN">Minnesota</option>
        <option value="MS">Mississippi</option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
        <option value="ND">North Dakota</option>
        <option value="OH">Ohio</option>
        <option value="OK">Oklahoma</option>
        <option value="OR">Oregon</option>
        <option value="PA">Pennsylvania</option>
        <option value="RI">Rhode Island</option>
        <option value="SC">South Carolina</option>
        <option value="SD">South Dakota</option>
        <option value="TN">Tennessee</option>
        <option value="TX">Texas</option>
        <option value="UT">Utah</option>
        <option value="VT">Vermont</option>
        <option value="VA">Virginia</option>
        <option value="WA">Washington</option>
        <option value="WV">West Virginia</option>
        <option value="WI">Wisconsin</option>
        <option value="WY">Wyoming</option>
      </select> <br>
      <input type="submit" name="submit" value="Search">
    </form>

    <?php
      $databasecodeentry = $_POST['databasecodeentry'];
      $commonnameentry = $_POST['commonnameentry'];
      $scientificnameentry = $_POST['scientificnameentry'];
      $stateentry = $_POST['stateentry'];
      $zipentry = $_POST['zipcodeentry'];
      $seedentry = $_POST['seedentry'];
      $liveplantentry = $_POST['liveplantentry'];
      if (isset($_POST['submit'])){
        if(isset($_GET['go'])){
          $db=mysql_connect ("localhost", "hailey", "b0Mbu$") or die ('I cannot connect to the database because: ' . mysql_error());

          $mydb=mysql_select_db("milkweed");

          $sql="SELECT commonname, scientificname, databasecode, name, state, zip, url, email, phone, notes, seed, liveplant 
          FROM availability 
          JOIN plants 
          ON availability.plant_ID = plants.plant_ID 
          JOIN sources 
          ON availability.source_ID = sources.source_ID 
          WHERE state LIKE '$stateentry%' 
          AND databasecode LIKE '$databasecodeentry%' 
          AND commonname LIKE '$commonnameentry%' 
          AND scientificname LIKE '$scientificnameentry%' 
          AND zip LIKE '$zipentry%'";

          $result=mysql_query($sql);
            echo "<table border=1 width=80%>
                  <tr width=80%>
                  <th width=8.3%> Live Plants Available? </th>
                  <th width=8.3%> Seeds Available? </th>
                  <th width=8.3%> Common Name </th>
                  <th width=8.3%> Scientific Name </th>
                  <th width=8.3%> Plant Database Code </th>
                  <th width=8.3%> Source Name </th>
                  <th width=8.3%> State </th>
                  <th width=8.3%> ZIP </th>
                  <th width=8.3%> URL </th>
                  <th width=8.3%> Email </th>
                  <th width=8.3%> Phone </th>
                  <th width=8.3%> Notes </th>
                  </tr>\n";
            while($row=mysql_fetch_array($result)){
                      $commonname=$row['commonname'];
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
              
              echo "
                  <tr width=80%>
                  <td width=8.3%> $liveplant </td>
                  <td width=8.3%> $seed </td>
                  <td width=8.3%> $commonname </td>
                  <td width=8.3%> $scientificname </td>
                  <td width=8.3%> $databasecode </td>
                  <td width=8.3%> $name </td>
                  <td width=8.3%> $state </td>
                  <td width=8.3%> $zip </td>
                  <td width=8.3%> $url </td>
                  <td width=8.3%> $email </td>
                  <td width=8.3%> $phone </td>
                  <td width=8.3%> $notes </td>
                  </tr>\n";
            }
            echo "</table>";
        }
    }
    ?>
</body>

</html>
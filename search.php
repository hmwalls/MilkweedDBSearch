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

      $databasecodeentry = "'$databasecodeentry%'";
      $commonnameentry = "'$commonnameentry%'";
      $scientificnameentry = "'$scientificnameentry%'";
      $stateentry = "'$stateentry%'";
      $zipentry = "'$zipentry%'";
      $seedentry = '$seedentry%';
      $liveplantentry = "'$liveplantentry%'";

      if (isset($_POST['submit'])){
        if(isset($_GET['go'])){
          $pdo = new PDO('mysql:host=localhost;dbname=milkweed','hailey','b0Mbu$');
          $sql = "SELECT commonname, scientificname, databasecode, name, state, zip, url, email, phone, notes, seed, liveplant 
          FROM availability 
          JOIN plants 
          ON availability.plant_ID = plants.plant_ID 
          JOIN sources 
          ON availability.source_ID = sources.source_ID 
          WHERE state LIKE :stateentry
          AND databasecode LIKE :databasecodeentry
          AND commonname LIKE :commoannameentry
          AND scientificname LIKE :scientificnameentry
          AND zip LIKE :zipentry";
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(":stateentry", $stateentry);
          $stmt->bindParam(":databasecodeentry", $databasecodeentry);
          $stmt->bindParam(":commonnameentry", $commonnameentry);
          $stmt->bindParam(":scientificnameentry", $scientificnameentry);
          $stmt->bindParam(":zipentry", $zipentry);
          $stmt->execute();
          while($row = $stmt->fetch()){
            print_r($row);
            echo"stuff";
          }
        }
    }
    ?>
</body>

</html>
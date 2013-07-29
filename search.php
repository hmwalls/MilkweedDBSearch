<?php
$dbuser = 'hailey';
$dbpassword = "b0Mbu$";

try {
  $pdo = new PDO('mysql:dbname=milkweed;host=localhost', $dbuser, $dbpassword);
}
catch (PDOException $e) {
  die ('data fails');
}

$plant_query = "select databasecode, commonname, scientificname from plants;";
$stmt = $pdo->prepare($plant_query);

if (!$stmt->execute()) {
  print_r($stmt->errorInfo());
}

$plants = array();
foreach ($stmt as $row) {
  array_push($plants, array(
    'databasecode' => trim($row['databasecode']), 
    'commonname' => $row['commonname'],
    'scientificname' => $row['scientificname']
    ));
}

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Search Contacts</title>
  </head>

  <body>
    <h3>Search For Native Milkweed Seed</h3>
    <form method="post" action="search.php" id="searchform"> <br>
        Plant Species: <select name="databasecodeentry">
        <option value="">Any Species</option>
        <?php
        foreach ($plants as $plant) {
          ?>
          <option value="<?php echo $plant['databasecode']; ?>"><?php print $plant['commonname']; ?> (<?php echo $plant['scientificname']; ?>)</option>
          <?php
        }
        ?>
        </select><br>
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
      <input type="submit" name="submit_button" value="Search">
    </form>
<table>
  <?php

  if (isset($_POST['submit_button'])){

    $terms = array();

    if (isset($_POST['databasecodeentry'])) {
      $databasecodeentry = $_POST['databasecodeentry'];

      $plantnameshow = "
          SELECT
            GROUP_CONCAT(CONCAT('<b>', plants.commonname, '</b> (<i>', plants.scientificname, '</i>)') SEPARATOR '<br/>') as plant_html
          FROM
            plants
          WHERE
            plants.databasecode = :databasecodeentry
          ";
      $stmt2 = $pdo->prepare($plantnameshow);

      echo "dbce = " . $databasecodeentry;
      if (!$stmt2->execute(array(':databasecodeentry' => $databasecodeentry))) {
        print_r($stmt->errorInfo());
      }
      else {
        if ($stmt2->rowCount() > 0) {
          $bs=  $stmt2->fetch(PDO::FETCH_ASSOC);
          print_r($bs);
          array_push($terms, $bs['plant_html']);
        }   
        else {
          array_push($terms, "Any species");
        }     
      }
    }

    if (isset($_POST['stateentry'])) {
      $stateentry = $_POST['stateentry'];
      echo "state entry = " . $stateentry;

      $statename = array (
      'AL'=>'Alabama',
      'AK'=>'Alaska',
      'AZ'=>'Arizona',
      'AR'=>'Arkansas',
      'CA'=>'California',
      'CO'=>'Colorado',
      'CT'=>'Connecticut',
      'DE'=>'Delaware',
      'DC'=>'District of Columbia',
      'FL'=>'Florida',
      'GA'=>'Georgia',
      'HI'=>'Hawaii',
      'ID'=>'Idaho',
      'IL'=>'Illinois',
      'IN'=>'Indiana',
      'IA'=>'Iowa',
      'KS'=>'Kansas',
      'KY'=>'Kentucky',
      'LA'=>'Louisiana',
      'ME'=>'Maine',
      'MD'=>'Maryland',
      'MA'=>'Massachusetts',
      'MI'=>'Michigan',
      'MN'=>'Minnesota',
      'MS'=>'Mississippi',
      'MO'=>'Missouri',
      'MT'=>'Montana',
      'NE'=>'Nebraska',
      'NV'=>'Nevada',
      'NH'=>'New Hampshire',
      'NJ'=>'New Jersey',
      'NM'=>'New Mexico',
      'NY'=>'New York',
      'NC'=>'North Carolina',
      'ND'=>'North Dakota',
      'OH'=>'Ohio',
      'OK'=>'Oklahoma',
      'OR'=>'Oregon',
      'PA'=>'Pennsylvania',
      'RI'=>'Rhode Island',
      'SC'=>'South Carolina',
      'SD'=>'South Dakota',
      'TN'=>'Tennessee',
      'TX'=>'Texas',
      'UT'=>'Utah',
      'VT'=>'Vermont',
      'VA'=>'Virginia',
      'WA'=>'Washington',
      'WV'=>'West Virginia',
      'WI'=>'Wisconsin',
      'WY'=>'Wyoming',);

      if (isset($statename[$stateentry])) {
        array_push($terms, $statename[$stateentry]);
      }
      else
        array_push($terms, "any state");
    }

    $subquery = "
    (select 
      sources.source_ID,
      GROUP_CONCAT(plants.databasecode SEPARATOR '|') as codes_avail 
    from 
      sources join 
      availability on sources.source_ID = availability.source_ID 
      join plants on availability.plant_ID = plants.plant_ID 
    group by sources.source_ID)
    ";

    $query = "
    SELECT 
      GROUP_CONCAT(CONCAT('<b>', plants.commonname, '</b> (<i>', plants.scientificname, '</i>)') SEPARATOR '<br/>') as plant_html,
      sources.name, 
      sources.state, 
      sources.zip, 
      sources.url, 
      sources.email, 
      sources.phone, 
      sources.notes 
    FROM 
      " . $subquery . " as avail 
      JOIN sources ON avail.source_ID = sources.source_ID 
      JOIN availability on availability.source_ID = avail.source_ID 
      JOIN plants ON availability.plant_ID = plants.plant_ID 
    WHERE 
      sources.state LIKE CONCAT(:stateentry, '%') AND 
      avail.codes_avail LIKE CONCAT('%', :databasecodeentry, '%') 
    GROUP BY sources.source_ID
    ORDER BY sources.name";
    $stmt = $pdo->prepare($query);

    if (!$stmt->execute(array(':stateentry' => $stateentry, ':databasecodeentry' => $databasecodeentry))) {
      print_r($stmt->errorInfo());
    }

    $search_terms = implode(" and ", $terms);

    if ($stmt->rowCount() > 0) {
      if (count($terms)) {
        echo "Results for " . $search_terms;
      }

      foreach ($stmt as $row) {

        $plant_html=$row['plant_html'];
        $name=$row['name'];
        $state=$row['state'];
        $zip=$row['zip'];
        $url=$row['url'];
        $email=$row['email'];
        $phone=$row['phone'];
        $notes=$row['notes'];

        $email = trim($email);

        if ($email) {
          $email = $email . "<br>";
        }

        $phone = trim($phone);

        if ($phone) {
          $phone = $phone . "<br>";
        }

        if ($url) {
          $url2 = $url . "<br>";
        }

        echo "
        <tr><td><p>
        <h3><a target = '_blank' href=\"$url\"> $name, $state</a></h3>
        $phone
        $email
        $url2
        <br>
        Available Species:
        <br>

        $plant_html<br>
        <br>

        $notes
        </p></td></tr>
        ";
      }
    }
    else {
      echo "No results found for " . $search_terms;
    }
  }
  ?>
  </table>
</body>

</html>
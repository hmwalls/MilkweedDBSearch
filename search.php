<?php
$dbuser = 'hailey';
$dbpassword = "b0Mbu$";

try {
  $pdo = new PDO('mysql:dbname=milkweed;host=localhost', $dbuser, $dbpassword);
}
catch (PDOException $e) {
  die ('data fails');
}

$plant_query = "select databasecode, commonname, scientificname from plants WHERE plants.databasecode LIKE 'A%' ORDER BY plants.commonname;";
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

$terms = array();
$search_results = NULL;
$databasecodeentry = "";
$stateentry = "";
$search_terms = "";

if (isset($_POST['submit_button'])){

  if (isset($_POST['databasecodeentry']))
    $databasecodeentry = $_POST['databasecodeentry'];

  if (isset($_POST['stateentry']))
    $stateentry = $_POST['stateentry'];

  if (strlen($_POST['databasecodeentry'])) {
    $plantnameshow = "
        SELECT
          CONCAT('<b>', plants.commonname, '</b> (<i>', plants.scientificname, '</i>)') as plant_html
        FROM
          plants
        WHERE
          plants.databasecode LIKE CONCAT('%', :databasecodeentry, '%')
        ";
    $stmt2 = $pdo->prepare($plantnameshow);

    if (!$stmt2->execute(array(':databasecodeentry' => $databasecodeentry))) {
      print_r($stmt->errorInfo());
    }
    else {
      $bs = $stmt2->fetch(PDO::FETCH_ASSOC);
      $plant_html = $bs['plant_html'];
      if ($plant_html) {
        array_push($terms, $plant_html);
      }   
      else {
        array_push($terms, "any species");
      }     
    }
  }
  else {
    array_push($terms, "any species");
  }

  if (strlen($stateentry)) {
    if (isset($statename[$stateentry])) {
      array_push($terms, $statename[$stateentry]);
    }
    else
      array_push($terms, "any state");
  }
  else {
    array_push($terms, "any state");
  }
  $search_terms = implode(" and ", $terms);

  $subquery = "
    (select 
      sources.source_ID,
      GROUP_CONCAT(plants.databasecode SEPARATOR '|') as codes_avail 
    from 
      sources join 
      availability on sources.source_ID = availability.source_ID 
      join plants on availability.plant_ID = plants.plant_ID 
    WHERE
    availability.seed LIKE 'yes' 
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
      avail.codes_avail LIKE CONCAT('%', :databasecodeentry, '%') AND
      availability.seed LIKE 'yes' 
    GROUP BY sources.source_ID
    ORDER BY sources.name";
    $stmt = $pdo->prepare($query);

    if (!$stmt->execute(array(':stateentry' => $stateentry, ':databasecodeentry' => $databasecodeentry))) {
      print_r($stmt->errorInfo());
    }

    $search_results = array();

    foreach ($stmt as $row) {
      array_push($search_results, $row);
    }
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
          <option value="<?php echo $plant['databasecode']; ?>"<?php if ($plant['databasecode'] == $databasecodeentry) { echo " selected"; }?>><?php print $plant['commonname']; ?> (<?php echo $plant['scientificname']; ?>)</option>
          <?php
        }
        ?>
        </select><br>
        State: <select name="stateentry">
        <option value="">Any State</option>
        <?php
        $keys = array_keys($statename);
        foreach ($keys as $k) {
        ?>
          <option value="<?php echo $k; ?>"<?php if ($k == $stateentry) { echo " selected"; }?>><?php echo $statename[$k]; ?></option>
        <?php } ?>

      </select> <br>
      <input type="submit" name="submit_button" value="Search">
    </form>
<table>
  <?php

  if (is_null($search_results)) {
    // user has not searched
  }
  else if(count($search_results)) {
    echo "Results for " . $search_terms;

    foreach($search_results as $row) {
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
      <a target = '_blank' href=\"$url\"> $url2 </a>
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
  ?>
  </table>
</body>

</html>
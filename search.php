<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Search Contacts</title>
  </head>

  <body>
    <h3>Search For Native Milkweed</h3>
    <form method="post" action="search.php?go" id="searchform"> <br>
      
        Plant Species: <select name="databasecodeentry">
        <option value="">Any Species</option>
        <option value="ASTU">Butterfly Milkweed (Asclepias tuberosa)</option>
        <option value="ASSY">Common Milkweed (Asclepias syriaca)</option>
        <option value="ASVI2">Green Antelopehorn (Asclepias viridis)</option>
        <option value="ASHA">Hall's Milkweed (Asclepias hallii)</option>
        <option value="ASCO">Heartleaf Milkweed (Asclepias cordifolia)</option>
        <option value="ASFA">Mexican Whorled Milkweed (Asclepias fascicularis)</option>
        <option value="ASOV">Oval Leaf Milkweed (Asclepias ovalifolia)</option>
        <option value="ASHU3">Pinewoods Milkweed (Asclepias humistrata)</option>
        <option value="ASPU">Plains Milkweed (Asclepias pumila)</option>
        <option value="ASEX">Poke Milkweed (Asclepias exaltata)</option>
        <option value="ASSU3">Prairie Milkweed (Asclepias sullivantii)</option>
        <option value="ASPU2">Purple Milkweed (Asclepias purpurascens)</option>
        <option value="ASRU">Red Milkweed (Asclepias rubra)</option>
        <option value="ASVI">Short Green Milkweed (Asclepias viridiflora)</option>
        <option value="ASSP">Showy Milkweed (Asclepias speciosa)</option>
        <option value="ASIN">Swamp Milkweed (Asclepias incarnata)</option>
        <option value="ASHI">Tall Green Milkweed (Asclepias hirtella)</option>
        <option value="ASTE">Texas Milkweed (Asclepias texana)</option>
        <option value="ASAM">Wavy Leaved Milkweed (Asclepias amplexicaulis)</option>
        <option value="ASAL">Whitestem Milkweed (Asclepias albicans)</option>
        <option value="ASVE">Whorled Milkweed (Asclepias verticillata)</option>
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
          AND databasecode LIKE '$databasecodeentry%'";

          $result=mysql_query($sql);
            // echo "<table border=1 width=90%>
            //       <tr width=90%>
            //       <th width=10%> Plant Species </th>
            //       <th width=10%> Vendor Name </th>
            //       <th width=10%> State </th>
            //       <th width=10%> ZIP </th>
            //       <th width=10%> URL </th>
            //       <th width=10%> Email </th>
            //       <th width=10%> Phone </th>
            //       <th width=10%> Notes </th>
            //       </tr>\n";
            $n=0;
            while($row=mysql_fetch_array($result)){
                      $commonname[]=$row['commonname'];
                      $scientificname[]=$row['scientificname'];
                      $name[]=$row['name'];
                      $databasecode[]=$row['databasecode'];
                      $state[]=$row['state'];
                      $zip[]=$row['zip'];
                      $url[]=$row['url'];
                      $email[]=$row['email'];
                      $phone[]=$row['phone'];
                      $notes[]=$row['notes'];
                      $seed[]=$row['seed'];
                      $liveplant[]=$row['liveplant'];
              
              // echo "
              //     <tr width=90%>
              //     <td width=10%> $commonname ($scientificname) </td>
              //     <td width=10%> $name </td>
              //     <td width=10%> $state </td>
              //     <td width=10%> $zip </td>
              //     <td width=10%> $url </td>
              //     <td width=10%> $email </td>
              //     <td width=10%> $phone </td>
              //     <td width=10%> $notes </td>
              //     </tr>\n";
              echo "
              <td><p><strong> $commonname[$n] </strong> (<i>$scientificname[$n]</i>)<br>
              $name[$n], $state[$n]<br>
              $url[$n], $email[$n], $phone[$n]<br>
              $notes[$n]</p></td>
              ";
              $n=$n+1;
            }
            echo "</table>";
        }
    }
    ?>
</body>

</html>
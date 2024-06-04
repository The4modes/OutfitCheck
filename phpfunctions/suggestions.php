<?php
  $sql = "SELECT * FROM Location";

  $locations = array();

  $db = new SQLite3("../db/outfitCheck.db");

  $result = $db->query($sql);

  while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    array_push($locations, $row["PlaceId"] . "%%%%" . $row["LocationName"] . "%%%%" . $row["LocationCountry"]);
  }

  $locationTry = $_POST['suggestion'];

  if(!empty($locationTry)){
    foreach ($locations as $location) {
      if(strpos(strtolower( $location), strtolower( $locationTry)) !== false){
        $locationarray = explode('%%%%', $location);
        echo '<div class="suggestion" id="' . $locationarray[0] . '">
        <p class="suggestion-p">'. $locationarray[1] . ', '. $locationarray[2] .'</p>
      </div>';
      }
    }
  }

  $db->close();
?>
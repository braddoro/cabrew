<?php
$eventID = 6;
$start = 122;
$beerCount = 0;
$cabrew_array = parse_ini_file('../server.ini', true);
$hostname = $cabrew_array['database']['hostname'];;
$username = $cabrew_array['database']['username'];
$password = $cabrew_array['database']['password'];
$dataname = $cabrew_array['database']['dbname'];
$mysqli = new mysqli($hostname, $username, $password, $dataname);
if(mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$fetch = "select eventBeerID from eventBeers where eventID = $eventID and beerCode is null order by rand();";
if($stmt = $mysqli->prepare($fetch)){
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $err = 1062;
        while($err = 1062){
            $start++;
            $update = "UPDATE eventBeers SET beerCode = {$start} WHERE eventBeerID = {$row['eventBeerID']};";
            if($updt = $mysqli->prepare($update)){
                $updt->execute();
                $err = $mysqli->errno;
                if($err != 1062){
                    if($err != 0){
                        echo 'Execute Error: ' . $mysqli->errno . '-' .$mysqli->error . "<br/>";
                    }
                    $beerCount++;
                    break;
                }
            }else{
                echo 'Prepare Error: ' .$mysqli->error . "<br/>";
            }
        }
    }
}
$mysqli->close();
echo 'Event ID: ' . $eventID . "<br/>";
echo 'Max Code: ' . $start . "<br/>";
echo 'Beers Processed: ' . $beerCount . "<br/>";
?>

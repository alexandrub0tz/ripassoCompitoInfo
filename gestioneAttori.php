<?php

include "connessione.php";

$nLimit = $_GET["numeroAttori"]; 

if(isset($_GET["numeroAttori"])){
    $nLimit = $_GET["numeroAttori"];
} else {
    $nLimit = 0;
}

if($nLimit < 1){
    echo "Nessun attore selezionato";
    exit();
}

$sql = "SELECT count(CodAttore) FROM attori";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($nLimit >= $row["count(CodAttore)"]){
    echo "il numero fornito è maggiore rispetto al numero totale degli attori. Saranno mostrati " . $row["count(CodAttore)"] . " attori <br>";
    $nLimit = $row["count(CodAttore)"];
}


$sql = "SELECT CodAttore,Nome FROM attori ORDER BY Nome ASC LIMIT $nLimit ";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {

    $sql = "SELECT film.CodFilm, film.Titolo, film.AnnoProduzione FROM recita
    JOIN film on film.CodFilm = recita.Codfilm WHERE recita.CodAttore = " . $row["CodAttore"];

    $result2 = $conn->query($sql);

    $sql = "SELECT count(codFilm) FROM recita WHERE recita.CodAttore =" . $row["CodAttore"];

    $result3 = $conn->query($sql);



    foreach($row as $key => $value) {
        echo $key . " : " . $value . " ";
    }


    while($row3 = $result3->fetch_assoc()){
        if($row3["count(codFilm)"] > 0){
            echo "<br>" . "Numero di film in cu ha recitato:" . $row3["count(codFilm)"];
        }          
    }
   

    if($result2->num_rows > 0){
        while($row2 = $result2->fetch_assoc()){
            echo "<br>" . "codice film:" . $row2["CodFilm"] . " " . "titolo:" . $row2["Titolo"] . " "
            . "anno:" . $row2["AnnoProduzione"] ;      
         }
         echo "<br>";

    } else {
        echo "<br>" . "Numero di film in cui ha recitato: 0";
        echo "<br>";
    }

   



    echo "<br>";
}



?>
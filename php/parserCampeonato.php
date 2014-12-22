<?php

//Parser para apuestas de campeonatos
foreach($xml->children() as $Game) {
  $flag=true; 
    if ( ($Game["name"] == "AL Winner 2014")) {
    $flag=0;
    }
    if (($Game["name"] == "NL Winner 2014")) {
    $flag=0;
    }
    if (($Game["name"] == "World Series Winner 2014")) {
    
      $flag=0;
    }
    //Entro a una apuesta por Juego
    if (!$flag){
      $count=$count+1;
      $participant[]=(string) $Game->Participant[0];
      $participant[]=(string) $Game->Participant[1];
    }  

}

?>
<?php
/*TODO 
  formatear los datos de los tipos de apuestas para que puedan ser reconocidos como JSON
  hallar algoritmo para conocer la hora de los juegos en nuestra zona horario
  Agregar el tipo de apuesta runlina cuando se conozca como funciona*/

  $xml = simplexml_load_file("baseball2.xml") or die("Error: Cannot create object");
  $countJuegos = 0;//Contador que calcula la cantidad total de juegos activos
  $countGanar = 0;//Contador para las apuestas a Ganar utilizada para crear un array asociativo dinamico (array("aGanar".$countGanar)
  $countHandicad = 0;//Contador para las apuestas Handicad utilizada para crear un array asociativo dinamico (aHandicap".$countHandicad)
  $countAltaBajaE = 0;//Contador para las apuestas Altas y bajas por equipo utilizada para crear un array asociativo dinamico (aHandicap".$countHandicad)
  $countAltaBajaJ = 0;//Contador para las apuestas Altas y bajas por Juego utilizada para crear un array asociativo dinamico (aHandicap".$countHandicad)

  $juego = array();//Array asociativo para guardar los participantes de cada juego
  $aGanar = array();//Array asociativo para guardar los datos de las apuestas a Ganar
  $temp = array();//Array asociativo utilizado como acumulador para almacenar los datos de cada apuesta por interaccion del bucle
  $aHandicap = array();//Array asociativo para guardar los datos de las apuestas Handicap
  $aAltasBajasJuego = array();//Array asociativo para guardar los datos de las apuestas Altas y Bajas por Juego
  $aAltasBajasEquipo = array();//Array asociativo para guardar los datos de las apuestas Altas y Bajas por Equipo
  $apuestaJuegos = array();//Array asociativo que almacenara los demas arrays para enviar el JSON

  //Bucle principal para recorrer los elementos de todo XML
  foreach($xml->children() as $Game) {
    //Condicionales para saber si es una apuesta de Juego.
    $flag = true; 
      if ( ($Game["name"] == "AL Winner 2014")) {
        $flag = 0;
      }
      if (($Game["name"] == "NL Winner 2014")) {
        $flag = 0;
      }
      if (($Game["name"] == "World Series Winner 2014")) {
        $flag = 0;
      }
      //Si el elemento es una apuesta de juego este condicional entra a ese nodo.
      if ($flag){

        //Contador que calcula la cantidad total de juegos activos
        $countJuegos = $countJuegos + 1;
        //Setea los participantes de un juego dado
        $temp = array("Juego".$countJuegos => array(//Concatenamos el contador para almacenar todos los participantes de cada juego en distintas posiciones del array asociativo
                      "participante1" => (string) $Game->Participant[0],
                      "participante2" => (string) $Game->Participant[1]));

        //Acumulador para los participantes de los diversos juegos
        $juego = $juego + $temp;

        //Bucle para recorrer los outcomeset que son los elementos con los datos del tipo de apuesta
        foreach($Game->children() as $OutcomeSet) {

        //condicional para setear los datos de la apuesta aGanar de un juego dado
          if ($OutcomeSet["type"] == "Result"){

            $temp = array("aGanar".$countGanar=> array(
                            "odds1" => (string) $OutcomeSet->Outcome[0]["odds"],
                            "equipo1" => (string) $OutcomeSet->Outcome[0]->Participant,
                            "odds2" => (string) $OutcomeSet->Outcome[1]["odds"],
                            "equipo2" => (string) $OutcomeSet->Outcome[1]->Participant));
            
            $countGanar = $countGanar + 1;
            //Acumulador para las apuestas a Ganar
            $aGanar = $aGanar + $temp;
          }

          if ($OutcomeSet["type"] == "Handicap"){

             $temp = array("aHandicap".$countHandicad => array(
                            "odds1" => (string) $OutcomeSet->Outcome[0]["odds"],
                            "participante1" => (string) $OutcomeSet->Outcome[0]->Participant,
                            "optionalValue1" => (string) $OutcomeSet->Outcome[0]->OptionalValue1,
                            "odds2" => (string) $OutcomeSet->Outcome[1]["odds"],
                            "participante2" => (string) $OutcomeSet->Outcome[1]->Participant,
                            "optionalValue2" => (string) $OutcomeSet->Outcome[1]->OptionalValue1,));

              $countHandicad = $countHandicad + 1;
              //Acumulador para las apuestas Runline
              $aHandicap = $aHandicap + $temp;
          }

          if ($OutcomeSet["type"] == "Under/Over Team"){

             $temp = array("aAltasBajasEquipo".$countAltaBajaE=> array(
                            "odds1" => (string) $OutcomeSet->Outcome[0]["odds"],
                            "apuesta1" => (string) $OutcomeSet->Outcome[0]["name"],
                            "optionalValue1" => (string) $OutcomeSet->Outcome[0]->OptionalValue1,
                            "equipo1" => (string) $OutcomeSet->Outcome[0]->Participant,
                            "odds2" => (string) $OutcomeSet->Outcome[1]["odds"],
                            "apuesta2" => (string) $OutcomeSet->Outcome[1]["name"],
                            "equipo2" => (string) $OutcomeSet->Outcome[1]->Participant,
                            "optionalValue2" => (string) $OutcomeSet->Outcome[1]->OptionalValue1));

              $countAltaBajaE = $countAltaBajaE + 1;
              //Acumulador para las apuestas Altas y Bajas por equipo
              $aAltasBajasEquipo = $aAltasBajasEquipo + $temp;
          }

        //condicional para setear los datos de la apuesta Altas y bajas
          if ($OutcomeSet["type"] == "Under/Over Match"){

             $temp = array("aAltasBajasPartido".$countAltaBajaJ  => array(
                            "odds1" => (string) $OutcomeSet->Outcome[0]["odds"],
                            "apuesta1" => (string) $OutcomeSet->Outcome[0]["name"],
                            "optionalValue1" => (string) $OutcomeSet->Outcome[0]->OptionalValue1,
                            "equipo1" => (string) $OutcomeSet->Outcome[0]->Participant,
                            "odds2" => (string) $OutcomeSet->Outcome[1]["odds"],
                            "apuesta2" => (string) $OutcomeSet->Outcome[1]["name"],
                            "equipo2" => (string) $OutcomeSet->Outcome[1]->Participant,
                            "optionalValue2" => (string) $OutcomeSet->Outcome[1]->OptionalValue1));
                
              $countAltaBajaJ = $countAltaBajaJ + 1;
              //Acumulador para las apuestas Altas y Bajas del Juego
              $aAltasBajasJuego = $aAltasBajasJuego + $temp;
          }

        }

      }  

  }

  //Agrega los datos seateados anteriormente en un array asosiativo paara poder enviarlos como un JSON
  $apuestaJuegos = array("nombreLiga" => "MLB", 
                          "juegosActivos" => $countJuegos,
                          "Ganar" => $countGanar,
                          "Handicap" => $countHandicad,
                          "AltasBajasJuego" => $countAltaBajaJ,
                          "AltasBajasEquipo" => $countAltaBajaE,
                          "Juegos" => $juego, "aGanar" => $aGanar,
                          "aHandicap" => $aHandicap,
                          "aAltasBajasPartido" => $aAltasBajasJuego,
                          "aAltasBajasEquipo" => $aAltasBajasEquipo);

  /*$apuestaJuegos= array("nombreLiga" => "MLB", 
              "juegosActivos" => $count);*/

  //concatenacion de arrays asociativos para poder enviarlos como un JSON
  echo json_encode($apuestaJuegos);

?>
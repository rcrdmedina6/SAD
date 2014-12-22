
  <?php

  $xml=simplexml_load_file("baseball.xml") or die("Error: Cannot create object");



  switch ($xml->Game->Region) {

  	case 'United States of America':

  		$nombreLiga= "MLB";

  		break;
  	
  	default:
  		# code...
  		break;
  }

  $count=0;
  $participant=0;
  $participantes=array();

  foreach($xml->children() as $Game) {
  	$flag=1;
  	if ( ($Game["name"] == "AL Winner 2014")) {
		$flag=0;
  	}
  	if (($Game["name"] == "NL Winner 2014")) {
		$flag=0;
  	}
  	if (($Game["name"] == "World Series Winner 2014")) {
  		$flag=0;
  	}

  	if ($flag){
  		$count=$count+1;
  		$participant=$participant+ 1;
  		$participantes= array("participant".$participant => $Game->Participant);
  	}
  }

  $juegosActivos[]= array("juegosActivos" => $count);
  /*foreach ($arrayNodos as $indixe) {
  	//print_r($indixe);
  	//echo '<br>';
  }*/


  //print_r($arrayNodos);
  //echo $count;
  $array[0]=$nombreLiga;
  $array[1]=$participantes;
  $array[2]=$juegosActivos;
  $participante=$xml->Game[3]->Participant[0];
  //"participantes:".


  $json = array('nombreLiga' => $nombreLiga,
  				'participante1' => $xml->Game[3]->Participant);
  

 

  $json = json_encode($xml);

  print $json;
  

  /*$array = ['foo' => $nombreLiga, 'quux' => $participante];
  echo $nombreLiga;
  echo $participante;*/
  ?>
<?php
 
$pregunta = new stdClass();
$pregunta->titulo = "Altitud del monte Everest";
$pregunta->categoria = "Cultura";
$pregunta->respuestas = array("respuesta1"=>8850,"respuesta2"=>8900,"respuesta3"=>8875);

$return["json"] = json_encode($pregunta);
print_r($return);
?>
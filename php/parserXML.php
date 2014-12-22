<?php
	
	class parserBaseball{

		private $root="Game";

		private $xml;

		private $arrayNodos=array();

		public function __construct($xml){

			$this->xml=$xml;

		}

		public function parser(){

			simplexml_load_file($this->xml) or die("No se pudo cargar el XML");
			
  			$this->arrayNodos[0]= $this->xml->$this->root;

		}

	}


	$xml="baseball.xml";

  	$baseballMLB= new parserBaseball($xml);

  	$JSON = $baseballMLB->parser();

	echo $JSON;

?>


parserBaseball baseballMLB = parserBall(xml);


baseballMLB->parser();
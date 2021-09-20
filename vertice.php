<?php
class Vertice{

	private $id;
	private $visitado;

	public function __construct($i){

		$this->id = $i;
		$this->visitado = false;

	}

	public function getId(){
		return $this->id;
	}

	public function setId($i){
		$this->id = $i;
	}

	public function getVisitado(){
		return $this->visitado;
	}

	public function setVisitado($v){
		$this->visitado = $v;
	}


}


?>
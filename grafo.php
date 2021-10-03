<?php
include("vertice.php");
Class Grafo{

	
		private $matrizA;
		private $vectorV;
		private $dirigido;

		public function __construct($dir = true){
			$this->matrizA = null;
			$this->vectorV = null;
			$this->dirigido = $dir;
		}

		//recibe objeto tipo vertice, no pueden repetirce id
		public function agregarVertice($v){
			if(!isset($this->vectorV[$v->getId()])){
				$this->matrizA[$v->getId()] = null;
				$this->vectorV[$v->getId()] = $v;
			} else{
				return false;
			}
			return true;

		}

		public function getVertice($v){
			return $this->vectorV[$v];
		}

		//recibe id de nodo origen, destino y peso (opcional)
		public function agregarArista($origen, $destino, $peso = null){
			if (isset($this->vectorV[$origen]) && isset($this->vectorV[$destino])){
				$this->matrizA[$origen][$destino] = $peso;
			}else{
				return false;
			} 

			return true;
		}

		//recibe id de nodo y retorna en un arreglo sus adyacentes.
		public function getAdyacentes($v){
			$mensaje = "Adyacentes de $v<br>";
			if($this->matrizA[$v] != null){
				$mensaje = $mensaje."$v->";
				foreach ($this->matrizA[$v] as $vertice => $peso) {
					$mensaje = $mensaje."| $vertice | $peso |--";
				}
			}else{
				return false;
			}
			return $mensaje;
		}

		public function getMatrizA(){
			return $this->matrizA;
		}

		public function getVectorV(){
			return $this->vectorV;
		}

		//recibe el id del vertice y retorna grado de salida del mismo
		public function gradoSalida($v){	
			if ($this->matrizA[$v] != null) {
				return count($this->matrizA[$v]);
			}else{
				return 0;
			}
		}

		public function gradoEntrada($v){
			$gr = 0;
			if ($this->matrizA != null){
				foreach ($this->matrizA as $vp => $adya) {
					if($adya !=null){
						foreach ($adya as $de => $pe) {
							if($de == $v){
								$gr++;
							}
						}
					}
				}
			}
			return $gr;
		}

		//recibe el id del vertice y retorna grado del mismo
		public function grado($v){
			if ($this->gradoSalida($v)==0) {
				return $this->gradoEntrada($v);
			}else if($this->gradoSalida($v) == 0 && $this->gradoEntrada($v)==0){
				return 0;
			}else{
				return $this->gradoSalida($v) + $this->gradoEntrada($v);
			}
		}

		//recibe id de vertice origen y destino
		public function eliminarArista($origen, $destino){
			if (isset($this->matrizA[$origen][$destino])){
				unset($this->matrizA[$origen][$destino]);
			}else{
				return false;
			}

			return true;
		}

		//recibe id de vertice a eliminar, elimina aristas relacionadas
		public function eliminarVertice($v){
			if(isset($this->vectorV[$v])){
				foreach ($this->matrizA as $vp => $adya) {
					if($adya !=null){
						foreach ($adya as $de => $pe) {
							if($de == $v){
								unset($this->matrizA[$vp][$de]);
							}
						}
					}
				}
				unset($this->matrizA[$v]);
				unset($this->vectorV[$v]);
			} else{
				return false;
			}
			return true;
		}

		public function Caminomascorto($a,$b){
			$s = array();
			$q = array();
			foreach (array_keys($this->matrizA) as $val) {
				$q[$val] = 99999;
				$q[$a] = 0;
				while (!empty($q)) {
					
					$min = array_search(min($q),$q);
					if ($min == $b) {
						break;
					}
					foreach ($this->matrizA[$min] as $key => $val) {
						# code...
						if (!empty($q[$key])&&$q[$min]+$val<$q[$key]) {
							$q[$key]= $q[$min]+$val;
							$s[$key]= array($min, $q[$key]);
						}
						unset($q[$min]);
					}
					$path = array();
					$pos = $b;
					while ($pos!=$a) {
						# code...
						$path[]=$pos;
						$pos = $s[$pos][0];
					}
					$path[] = $a;
					$path = array_reverse($path);
					return $path;
				}
			}
		}

		public function DFSVisitar($Nodo, $tiempo){
			$Visitado = array();
			$Visitado[$Nodo] = "VISITADO";
			$tiempo = $tiempo+1;
			$d[$Nodo]= $tiempo;
			foreach ($Nodo as $key => $value) {
				# code...
			}
			$Visitado[$Nodo]= "TERMINADO";
			$tiempo = $tiempo + 1;
			$f = array();
			$f[$Nodo]=$tiempo;
		}

		public function DFS($G,$vertice){
			$Visitado = array();
			$padre = array();
			$tiempo = 0;
			foreach ($vertice as $key => $value) {
				# code...
				$Visitado[$key]= "NO VISITADO";
				$padre[$key] = null;
				$tiempo = 0;
			}
			foreach ($vertice as $key => $value) {
				# code...
				if ($Visitado[$vertice]=="NO VISITADO") {
					# code...
					$this->DFSVisitar($vertice,$tiempo);
				}
			}

		}

		

}
?>
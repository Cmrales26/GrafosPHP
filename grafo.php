<?php
include("vertice.php");
Class Grafo{

	
		private $matrizA;
		private $vectorV;
		private $dirigido;

		public $visited = [];
		public $graph = [];

		public function __construct($dir = true){
			$this->matrizA = null;
			$this->vectorV = null;
			$this->dirigido = $dir;
		}

		//recibe objeto tipo vertice, no pueden repetirce id
		public function agregarVertice($v){
			if(!isset($this->vectorV[$v->getId()])){
                $this->matrizA[$v->getId()] = [];
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

		public function getAdyacentes2($v){
			return $this->matrizA[$v];
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

		public function caminoMasCorto($a,$b){ //TERMINADO
            $S = array();
            $Q = array();
            foreach(array_keys($this->matrizA) as $val) $Q[$val] = 99999;
            $Q[$a] = 0;
            // inicio calculo
            while(!empty($Q)){
                $min = array_search(min($Q), $Q);
                if($min == $b) break;
			foreach ($this->matrizA[$min] as $key => $val) if(!empty($Q[$key]) && $Q[$min]+ $val < $Q[$key]) {
					$Q[$key] = $Q[$min] + $val;
                    $S[$key] = array($min, $Q[$key]);
				}
                unset($Q[$min]);
            }
            $path = array();
            $pos = $b;
            while($pos != $a){
                $path[] = $pos;
                $pos = $S[$pos][0];
            }
            $path[] = $a;
            $path = array_reverse($path);
            return $path;
        }

	public function DFS($n){
		$R = [];
		if (isset($n)) {
			$R = $this->DFSR($n, $R);
		}
		return$R;
	}
	
	private function DFSR($n, $r){
		array_push($r, $n);
		$adya = array_keys($this->getAdyacentes2($n));
		sort($adya);
		foreach ($adya as $n_adya) {
			if (!in_array($n_adya, $r)){
				$r = $this->DFSR($n_adya, $r);
			}
		}
		return$r;
	}
		

		public function BFS($Nodo){
			$cola = [];
			$recorrido = [];
			if(isset($Nodo)){
				array_push($cola, $Nodo);
				while (count($cola)>0) {
					$NodoA = array_shift($cola);
					array_push($recorrido,$NodoA);
					$adyacentes = array_keys($this->getAdyacentes2($NodoA));
					sort($adyacentes);
					foreach ($adyacentes as $key) {
						if (!in_array($key, $recorrido)) {
							array_push($cola,$key);
						}
					}
				}
			}
			$array = array_unique($recorrido, $sort_flags = SORT_REGULAR);
			return $array;
		}
}
?>
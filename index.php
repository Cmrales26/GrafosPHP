<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type= "text/javascript" src= " vis/dist/vis.js"></script>
    <link href="vis/dist/vis.css" rel="stylesheet" type="text/css">
    <title>Visualizacion de Grafos con Vis.js</title>
</head>
	<style type="text/css">
		body{
            color: white;
			background: black;
		}
        #grafo1{
            width: 100%;
            height: 400px;
            border: 5px solid white;
            }
	</style>

	<title> Visualizacion de Grafos con Vis.js</title>
<body>
    <?php
    include("grafo.php");
    session_start();
    if (!isset($_SESSION["grafo"])) {
    $_SESSION["grafo"] = new grafo();
    }
?>
    <h2>Agregar vertice</h2>
        <form action="index.php" method="post" id="Agregar" >
            <label> Id vertice :  </label>
            <input type="text" name="AgregarVertice" required>
            <input type="submit" value="Agregar" >
        </form>
    <br><hr>

    
    <h2>Agregar Arista</h2>
        <form action="index.php" method="post" id= "Agregar">	
            <label> Vertice origen : </label>
            <input type="text" name="Origen" required>
            <label> Vertice Destino : </label>
            <input type="text" name="Destino" required>
            <label> Peso : </label>
            <input type="number" name="Peso" required>
            <input type="submit" value="Agregar">
        </form>
    <br><hr>

    <h2>Ver vertice</h2>
        <form action="index.php" method="post" id="Mostrar" >
            <label> Id vertice : </label>
            <input type="text" name="VerVertice" required>
            <input type="submit" value="Mostrar" >
        </form>
    <br><hr>

    <h2>Ver adyacente</h2>
        <form action="index.php" method="post" id="Mostrar" >
            <label> Id del vertice : </label>
            <input type="text" name="VerAdyacente" required>
            <input type="submit" value="Mostrar" >
        </form>
    <br><hr>


    <h2>Ver grado</h2>
        <form action="index.php" method="post" id="Mostrar" >
            <label> Id del vertice : </label>
            <input type="text" name="VerGrado" required>
            <input type="submit" value="Mostrar" >
        </form>
    <br><hr>


    <h2>Eliminar vertice</h2>
        <form action="index.php" method="post" id="Eliminar" >
        <label> Id del vertice : </label>
            <input type="text" name="EliminarVertice" required>
            <input type="submit" value="Eliminar" >
        </form>
    <br><hr>

    <h2>Eliminar arista</h2>
        <form action="index.php" method="post" id= "Eliminar">	
            <label> Vertice origen : </label>
            <input type="text" name="OrigenE" required>
            <label> Vertice Destino : </label>
            <input type="text" name="DestinoE" required>
            <input type="submit" value="Eliminar">
        </form>
    <br><hr>

        
    <?php
        
        if (isset($_POST["AgregarVertice"])) {
            $N = new Vertice($_POST["AgregarVertice"]);
            $_SESSION["grafo"]->agregarVertice($N);
        }

        if (isset($_POST["Origen"]) && isset($_POST["Destino"]) && isset($_POST["Peso"])) {
            $_SESSION["grafo"]->agregarArista($_POST["Origen"], $_POST["Destino"], $_POST["Peso"]);
        }

        if (isset($_POST["VerVertice"])) {
            echo "<br>";
            print_r($_SESSION["grafo"]->getVertice($_POST["VerVertice"]));
        }

        if (isset($_POST["VerAdyacente"])) {
            echo "<br>";
            $x = ( $_SESSION["grafo"]->getAdyacentes($_POST["VerAdyacente"]));
            if ($x == null) {                
                
                echo "<script language='javascript'>alert('No Existen Adyacentes del Vertice Ingresado');</script>";
                
                } else {
                print_r($x);
            }
        }

        if (isset($_POST["VerGrado"])) {
            echo "El Grado del Vertice " . ($_POST["VerGrado"]) . " es: ";
            print_r($_SESSION["grafo"]->grado($_POST["VerGrado"]));
        }

        if (isset($_POST["EliminarVertice"])) {
            $B = $_SESSION["grafo"]->eliminarVertice($_POST["EliminarVertice"]);
            if ($B) {
                echo "<br><hr>Vertice Eliminado<hr><br>";
            } else {
                
                echo "<script language='javascript'>alert('Por favor Ingrese un Vertice Valido');</script>";               
            }
        }

        if (isset($_POST["OrigenE"]) && isset($_POST["DestinoE"])) {
            $B = $_SESSION["grafo"]->eliminarArista($_POST["OrigenE"], $_POST["DestinoE"]);
            if ($B) {
                echo "<br><hr>Arista Eliminada<hr><br>";
            } else {
            
                echo "<script language='javascript'>alert('Por favor Ingrese una Arista Valida');</script>";               
            }
        }

?>
<div class="grafo1" id="grafo1"></div>
    <script>
        var nodos = new vis.DataSet([
        <?php
            $p = count($_SESSION["grafo"]->getVectorV());
            $cant = 0;
            foreach  ($_SESSION["grafo"]->getVectorV() as $i => $adya){
            $cant++;    
                if($cant == $p){
                    echo "{id: '$i', label: '$i'}";
                }else{
                    echo "{id: '$i', label: '$i'},";
                }
            }
        ?>
    ]);
            
        var aristas = new vis.DataSet([
            <?php
            $z = count($_SESSION["grafo"]->getMatrizA());
            foreach ($_SESSION["grafo"]->getMatrizA() as $x => $adyas){
            if($adyas != null){
                foreach($adyas as $y => $l){
                    if ($x == null){
                        echo "{from: '$x', to: '$y', label: '$l'}";
                    }else{
                        echo "{from: '$x', to: '$y', label: '$l'},";
                        }
                    }
                }
            }
            ?>
        ]);
            
        var contenedor = document.getElementById("grafo1");

        var datos = {
            nodes: nodos,
            edges: aristas
        };
        var opciones = {
        edges: {
            arrows: {
                to: {
                    enabled: true
                }
            }
        }
    }
    var grafo = new vis.Network(contenedor, datos, opciones);
    </script>
</body>
</html>
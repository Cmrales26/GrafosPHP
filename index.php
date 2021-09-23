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
            color: black;
			background: white;
		}
        #grafo1{
            width: 100%;
            height: 400px;
            border: 5px solid black;
            }
	</style>

	<title> Visualizacion de Grafos con Vis.js</title>
<body>
    <?php
    include("grafo.php");
    session_start();
    if (!isset($_SESSION["grafo"])) {
    $_SESSION["grafo"] = new grafo();
    echo "<script language='javascript'>alert('Se estan implementando el uso de las cookies');</script>";
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
            <input type="text" name="VerVertice" id="VerVertice" required >
            <input type="button" value="Mostrar" id="Mostrar_vertice">
        </form>
    <br><hr>

    <h2>Ver adyacente</h2>
        <form action="index.php" method="post" id="Mostrar" >
            <label> Id del vertice : </label>
            <input type="text" name="VerAdyacente" id="VerAdyacentes" required>
            <input type="submit" value="Mostrar" id="MostrarAdyacentes" >
        </form>
        <?php
            if (isset($_POST["VerAdyacente"])) {
            echo "<br>";
            $x = ( $_SESSION["grafo"]->getAdyacentes($_POST["VerAdyacente"]));
            if ($x == null) {
                echo "<script language='javascript'>alert('No Existen Adyacentes del Vertice Ingresado');</script>";
                } else {
                    print_r($x);
            }
        }
        ?>
    <br><hr>

    <h2>Ver grado</h2>
        <form action="index.php" method="post" id="Mostrar" >
            <label> Id del vertice : </label>
            <input type="text" name="VerGrado" required>
            <input type="submit" value="Mostrar" >
        </form>
        <?php
            if (isset($_POST["VerGrado"])) {
            echo "<br> El Grado del Vertice " . ($_POST["VerGrado"]) . " es: ";
            print_r($_SESSION["grafo"]->grado($_POST["VerGrado"]));
        }
        ?>
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
            $a = $_SESSION["grafo"]->agregarArista($_POST["Origen"], $_POST["Destino"], $_POST["Peso"]);
            if ($a == false){
                echo "<script language='javascript'>alert('El origen o el destino no se encuentrar Regitrado');</script>";
            }
        }


        if (isset($_POST["EliminarVertice"])) {
            $B = $_SESSION["grafo"]->eliminarVertice($_POST["EliminarVertice"]);
            if (!$B) {
                echo "<script language='javascript'>alert('Por favor Ingrese un Vertice Valido');</script>";
            }
        }

        if (isset($_POST["OrigenE"]) && isset($_POST["DestinoE"])) {
            $B = $_SESSION["grafo"]->eliminarArista($_POST["OrigenE"], $_POST["DestinoE"]);
            if (!$B) {
                echo "<script language='javascript'>alert('Por favor Ingrese una Arista Valida');</script>";
            }
        }

?>
<div class="grafo1" id="grafo1"></div>
    <script>
        var vertice_anterior=null;
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
        nodes: {
            borderWidthSelected: 10,
            color:{
                border: 'BLUE',
                background: 'White',
                highlight: {
                    border: 'RED',
                    background: 'White'
                }
            }    
        },
        edges: {
            color: {
                color:'BLACK',
                highlight:'RED',
            },
            arrows:{
                to:{
                    enabled: true
                }
            }
        }
    }
    var grafo = new vis.Network(contenedor, datos, opciones);

    const resaltar_aristas = ()=>{
        const vertice = document.getElementById('VerVertice').value;
        var edges = grafo.getConnectedEdges(vertice);
        grafo.selectEdges(edges, opciones);
        console.log(edges);
    }

    const Boton = document.getElementById('Mostrar_vertice');
    Boton.addEventListener('click', () => {
        const vertice = document.getElementById('VerVertice').value;
        if(vertice_anterior == null){
            console.log("Si no pongo este log sale un vertice de la nada :(")
        }else{
            nodos.update([{id: vertice_anterior, color:{border: "Blue"} }]);
        }
        var node = nodos.get(vertice);
        if(node == null){
            alert("El nodo ingresado no existe");
        }else{
            vertice_anterior = vertice;
            grafo.unselectAll();
            resaltar_aristas();
            nodos.update([{id: vertice, color:{border: "RED"} }]);
        }
    });
    </script>
</body>
</html>
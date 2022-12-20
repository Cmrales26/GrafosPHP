<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src=" vis/dist/vis.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis-network/9.1.2/standalone/umd/vis-network.min.js" integrity="sha512-DOpf3tO7m7MJHkMMRRoNxiJL4CR+TFLYy2XnIOeTh26Hz8j8i9RHrVkXzh+AQ7mffzIFk538/zcQ3Yoo+7VISA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="vis/dist/vis.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;500;700&display=swap"
        rel="stylesheet">
    <title>Visualización de Grafos con Vis.js</title>
</head>
<title> Visualización de Grafos con Vis.js</title>

<body>
    <?php
    include("grafo.php");
    session_start();
    if (!isset($_SESSION["grafo"])) {
    $_SESSION["grafo"] = new grafo();
    echo "<script language='javascript'>alert('Se están implementando el uso de cookies');</script>";
    }
?>
    <header>
        <h1>Visualización de Grafos PHP y Vis.js</h1>
    </header>
    <div class="grafo1" id="grafo1"></div>
    <div class="wrapper">
        <div class="Fila">
            <div class="Columnas">
                <div class="Columna_1">
                    <h2>Agregar vertice</h2>
                    <form action="index.php" method="post" id="Agregar">
                        <input type="text" name="AgregarVertice" placeholder="ID DEL VERTICE" required>
                        <input type="submit" value="Agregar">
                    </form>
                    <br>

                    <h2>Agregar Arista</h2>
                    <form action="index.php" method="post" id="Agregar">
                        <input type="text" name="Origen" placeholder="VERTICE DE ORIGEN" required>
                        <br><br>
                        <input type="text" name="Destino" placeholder="VERTICE DE DESTINO" required>
                        <br><br>
                        <input type="number" name="Peso" placeholder="PESO O PONDERADO" required>
                        <input type="submit" value="Agregar" class="Agregar">
                    </form>
                    <br>
                </div>
            </div>

            <div class="Columnas">
                <div class="Columna_2">
                    <h2>Ver vertice</h2>
                    <form action="index.php" method="post" id="Mostrar">
                        <input type="text" name="VerVertice" placeholder="ID DEL VERTICE" id="VerVertice" required>
                        <input type="button" value="Mostrar" id="Mostrar_vertice">
                    </form>
                    <h2>Ver adyacente</h2>
                    <form action="index.php" method="post" id="Mostrar">
                        <input type="text" name="VerAdyacente" placeholder="ID DEL VERTICE" id="VerAdyacentes" required>
                        <input type="submit" value="Mostrar" id="MostrarAdyacentes">
                    </form>
                    <?php
            if (isset($_POST["VerAdyacente"])) {
            $x = ( $_SESSION["grafo"]->getAdyacentes($_POST["VerAdyacente"]));
            if ($x == null) {
                echo "<script language='javascript'>alert('No Existen Adyacentes del Vértice Ingresado');</script>";
                } else {
                    echo"<span>".$x."</span>";
            }
        }
        ?>
        <br>
        <h2>Ver grado</h2>
        <form action="index.php" method="post" id="Mostrar">
            <input type="text" name="VerGrado" placeholder="ID DEL VERTICE" required>
            <input type="submit" value="Mostrar">
        </form>
        <?php
            if (isset($_POST["VerGrado"])) {
            $grado = ($_SESSION["grafo"]->grado($_POST["VerGrado"]));
            if ($grado != null) {
                echo "<br><p> El Grado del Vertice " . ($_POST["VerGrado"]) . " es: </p>";
                echo "<p>". $_SESSION["grafo"]->grado($_POST["VerGrado"])."</p>";
            }else{
                echo "<script>alert('El vértice no posee adyacentes o no se encuentra registrado');</script>";
            }
        }
        ?>
        </div>
    </div>
    
    <div class="Columnas">
        <div class="Columna_3">
            <br>
            <h2>Eliminar vertice</h2>
            <form action="index.php" method="post" id="Eliminar">
                <input type="text" name="EliminarVertice" placeholder="ID DEL VERTICE" required>
                <input type="submit" value="Eliminar">
            </form>
            <br>
            <h2>Eliminar arista</h2>
            <form action="index.php" method="post" id="Eliminar">
                <input type="text" name="OrigenE" placeholder="VERTICE DE ORIGEN" required>
                <br></br>
                <input type="text" name="DestinoE" placeholder="VERTICE DE DESTINO" required>
                <input type="submit" value="Eliminar">
            </form>
            <br>
        </div>
    </div>
    <div class="Columnas">
        <div class="Columna_4">
        <h2>Ver el camino mas corto</h2>
        <form action="index.php" method="post" id="Mostrar">
            <input type="text" name="nodoA" placeholder="Ingrese el nodo Inicial" required>
            <br><br>
            <input type="text" name="nodoB" placeholder="Ingrese el nodo Final" required>
            <input type="submit" value="Mostrar" id="mostrarCaminoCorto">
        </form>
        <?php
        if(isset($_POST['nodoA']) && isset($_POST['nodoB'])){
            $C = $_SESSION["grafo"]->caminoMasCorto($_POST["nodoA"], $_POST["nodoB"]);
            $C_S = implode("->",$C);
            echo"<p>El camino mas corto es: "."<br>".$C_S."</p>";
        }
        ?>
        </div>
    </div>
</div>
</div>
<div class="abajo">
    <div class="Fila">
            <div class="Columnas">
                <div class="Columna_1">

        <br>
        <h2>Ver recorrido de anchura</h2>
        <form action="index.php" method="post" id="recorridoAnchura">
            <input type="text" name="NodoC" placeholder="Ingrese el nodo para ver su recorrido de anchura">
            <input type="submit" value="Mostrar" id="mostrarRA">
        </form>
        <?php
            if(isset($_POST["NodoC"])){
                $A = $_SESSION["grafo"]->BFS($_POST["NodoC"]);
                $A_S = implode("->",$A);
                echo"<p>El recorrido de anchura es: <br></p>";
                echo "<P>$A_S</P>";
            }
        ?>
        </div>
        </div>

        
        <div class="Columnas">
            <div class="Columna_2">
                
        <h2>Ver recorrido de profundidad</h2>
        <form action="index.php" method="post" id= "recorridoProfundidad">
            <input type="text" name="NodoD" placeholder="Ingrese el nodo para ver su recorrido de profundidad">
            <input type="submit" value="Mostrar" id="mostrarRP">
        </form>
        <?php
        if(isset($_POST["NodoD"])){
            $B = $_SESSION["grafo"]->DFS($_POST["NodoD"]);
            $B_S = implode("->",$B);
            echo "<p> El recorrido de profundidad es:<br> </p>";
            echo "<p>$B_S</p>";
        }
        ?>
            </div>
        </div>
    </div>
</div>
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


    <script>
    var vertice_anterior = null;
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
        interaction: {
            zoomView: false
        },
        nodes: {
            borderWidth: 2,
            borderWidthSelected: 10,
            color: {
                border: '#444444',
                background: '#EDEDED',
                highlight: {
                    border: '#DA0037',
                    background: '#EDEDED'

                }
            },
            font: {
                color: '#DA0037',
                size: 18,
            }
        },
        edges: {
            color: {
                inherit: false,
                color: '#EDEDED',
                highlight: '#DA0037',
            },
            arrows: {
                to: {
                    enabled: true
                }
            }
        }
    }
    var grafo = new vis.Network(contenedor, datos, opciones);
    <?php
        if(isset($_POST['nodoA']) && isset($_POST['nodoB'])){
            $C = $_SESSION["grafo"]->caminoMasCorto($_POST["nodoA"], $_POST["nodoB"]);
            if ($C != null) {
                foreach ($C as $id => $vertice) {
                echo "nodos.update([{id: '$vertice',color: {border: 'RED'}}]);";
            }
            }else{
                echo "alert('El nodo ingresado no se encuentra registrado')";
        }
    }
    ?>
    </script>
    
    <script src="verVertice.js"></script>
    <footer>
        <p>Creado y diseñado por:  <a href="https://aulavirtual.cuc.edu.co/moodle/user/profile.php?id=149989" target="_blank" rel="noopener noreferrer">@Jesus Garcia</a> - <a href="https://aulavirtual.cuc.edu.co/moodle/user/profile.php?id=149267" target="_blank" rel="noopener noreferrer">@Nelson Morales</a> - <a href="https://aulavirtual.cuc.edu.co/moodle/user/profile.php?id=151565" target="_blank" rel="noopener noreferrer">@Yan De la Torre</a></p>
    </footer>
</body>
</html>
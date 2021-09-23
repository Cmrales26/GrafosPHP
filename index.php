<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src=" vis/dist/vis.js"></script>
    <link href="vis/dist/vis.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;500;700&display=swap"
        rel="stylesheet">
    <title>Visualizacion de Grafos con Vis.js</title>
</head>
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
    <header>
        <h1>Visualizacion de Grafos Php y Vis.js</h1>
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
                echo "<script language='javascript'>alert('No Existen Adyacentes del Vertice Ingresado');</script>";
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
                echo "<script>alert('El vertice no posee vertices vecinas o no se encuentra registrados');</script>";
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
    </script>
    <script src="verVertice.js"></script>
    <footer>
        <p>Creado y diseñodo por:  <a href="https://aulavirtual.cuc.edu.co/moodle/user/profile.php?id=149989" target="_blank" rel="noopener noreferrer">@Jesus Garcia</a> - <a href="https://aulavirtual.cuc.edu.co/moodle/user/profile.php?id=149267" target="_blank" rel="noopener noreferrer">@Nelson Morales</a> - <a href="https://aulavirtual.cuc.edu.co/moodle/user/profile.php?id=151565" target="_blank" rel="noopener noreferrer">@Yan De la Torre</a></p>
    </footer>
</body>
</html>
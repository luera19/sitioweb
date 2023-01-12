<?php include("../template/header.php"); ?>
<?php include("../config/bd.php"); ?>

<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


/* echo $txtID. "<br />";
    echo $txtNombre. "<br />";
    echo $txtImagen. "<br />";
    echo $accion. "<br />"; */

switch ($accion) {


    //AGREGAR
    case "Agregar";
        //INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de PHP', 'imagen.jpg');
        $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen', $txtImagen);
        $sentenciaSQL->execute();

        header("Location:libros.php");
        break;


    //EDITAR
    case "Editar";

        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != "") {
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img" . $libro["imagen"])) {
                    unlink("../../img" . $libro["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        header("Location:libros.php");
        break;

    //CANCELAR
    case "Cancelar";
        header("Location:libros.php");
        break;

    //SELECCIONAR    
    case "Seleccionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];
        


        break;

    //BORRAR        
    case "Borrar";

        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img" . $libro["imagen"])) {
                unlink("../../img" . $libro["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:libros.php");
        break;
}

        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
        $sentenciaSQL->execute();
        $listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del Libro
        </div>

        <div class="card-body">
            <!--enctype para recepción de imagenes-->
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" id="txtID" name="txtID" value="<?= $txtID; ?>" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" id="txtNombre" name="txtNombre" value="<?= $txtNombre; ?>" placeholder="Nombre del libro">
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>

                    <br />

                    <?php if ($txtImagen = !"") { ?>

                        <img class="img-thumbnail rounded" src="<?= "../../img/" . $libro['imagen']; ?>" width="50" alt="" srcset="">

                    <?php } ?>

                    <input type="file" required class="form-control" id="txtImagen" name="txtImagen" placeholder="Elija archivo imagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?= ($accion=="Seleccionar")?"disabled" :"";  ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?= ($accion!=="Seleccionar")?"disabled":""; ?> value="Editar" class="btn btn-warning">Editar</button>
                    <button type="submit" name="accion" <?= ($accion!=="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($listaLibros as $libro) { ?>

                <tr>
                    <td><?= $libro['id']; ?></td>
                    <td><?= $libro['nombre']; ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="<?= "../../img/" . $libro['imagen']; ?>" width="50" height="" alt="" srcset="">

                    </td>


                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="txtID" id="txtID" value=<?= $libro['id']; ?>>
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                        </form>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</div>


<?php include("../template/footer.php"); ?>
<?php include("template/header.php"); ?>

<?php 
include ("administrador/config/bd.php");
$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!--CARD-->
<?php foreach($listaLibros as $libro) { ?>

<div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="./img/<?=$libro['imagen'];?>" alt="" width="">
        <div class="card-body">
            <h4 class="card-title"><?= $libro['nombre'];?></h4>
            <a name="card1" id="card1" class="btn btn-primary" href="https://goalkicker.com/" role="button">Ver más</a>
        </div>
    </div>
</div>

<?php } ?>

<?php include("template/footer.php");

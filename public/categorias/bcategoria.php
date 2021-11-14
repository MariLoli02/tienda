<?php
    if(!isset($_POST['id'])){
        header("Location:index.php");
        die();
    }
    require dirname(__DIR__, 2)."/vendor/autoload.php";
    use Tienda\Categorias;
    (new Categorias)->delete($_POST['id']);
    $_SESSION['mensaje']="Categoria Borrada.";
    header("Location:index.php");
<?php
    if(!isset($_GET['id'])){
        header("Location:index.php");
        die();
    }
    session_start();
    $id=$_GET['id'];

    require dirname(__DIR__, 2)."/vendor/autoload.php";

    use Tienda\{Categorias, Articulos};

    $esteArticulo=(new Articulos)->read($id);
    $categorias=(new Categorias)->devolverCategorias();

    function hayError($n, $p){
        global $id;
        $error=false;
        if(strlen($n)==0){
            $error=true;
            $_SESSION['error_nombre']="Rellene el nombre";
        }
        if(strlen($p)==0){
            $error=true;
            $_SESSION['error_precio']="Este campo debe contener el precio";
        }
        return $error;
    }


    if(isset($_POST['btnUpdate'])){
        $nombre = trim(ucwords($_POST['nombre']));
        $precio = trim(ucwords($_POST['precio']));
        $categoria_id = $_POST['categoria_id'];
       
        if (!hayError($nombre, $precio)) {
            (new Articulos)->setNombre($nombre) 
                ->setPrecio($precio)
                ->setCategoria_id($categoria_id)
                ->setId($id)
                ->update();
            $_SESSION['mensaje'] = "Articulo Actualizado.";
            header("Location:index.php");
            die();
        } else {
            header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        }
    } else{
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- FONTAWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        
        <title>Editar Articulo</title>

    </head>
    <body style="background-color: silver;">
        <h4 class="text-center mt-4">Editar Articulo</h4>
        <div class="container mt-2">
            <div class="bg-success p-4 text-white rounded shadow-lg m-auto" style="width: 40rem;">
                <form name="uarticulo" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=$id" ?>">
                    <div class="mb-3">
                        <label for="n" class="form-label">Nombre Articulo</label>
                        <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" required value="<?php echo $esteArticulo->nombre; ?>"> 
                        <?php 
                            if(isset($_SESSION['error_nombre'])){
                                echo <<<TXT
                                    <div class="mb-2 text-danger fw-bold style="font-size:small">
                                        {$_SESSION['error_nombre']}
                                    </div>
                                TXT;
                                unset($_SESSION['error_nombre']);
                            }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="p" class="form-label">Precio Articulo</label>
                        <input type="number" class="form-control" id="p" rows="4" name="precio" value="<?php echo $esteArticulo->precio ?>">
                        <?php 
                            if(isset($_SESSION['error_precio'])){
                                echo <<<TXT
                                    <div class="mb-2 text-danger fw-bold style="font-size:small">
                                        {$_SESSION['error_precio']}
                                    </div>
                                TXT;
                                unset($_SESSION['error_precio']);
                            }
                        ?>
                    </div>

                    <div class="mb-3">
                    <label for="a" class="form-label">Categoria Articulo</label>
                        <select class="form-select" name="categoria_id">
                            <?php
                                foreach($categorias as $item){
                                    if($item->id==$esteArticulo->categoria_id){
                                        echo "\n<option value='{$item->id}' selected>{$item->nombre}, {$item->id}</option>";
                                    } else{
                                        echo "\n<option value='{$item->id}'>{$item->nombre}, {$item->id}</option>";
                                    }
                                }
                                
                            ?>
                        </select>
                    </div>
                   
                    <div class="mb-3">
                        <button type='submit' name="btnUpdate" class="btn btn-info"><i class="fas fa-edit"></i> Editar</button>
                        <a href="index.php" class="btn btn-primary"> <i class="fas fa-backward"></i>Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php } ?>
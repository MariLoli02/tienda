<?php 
    require dirname(__DIR__, 2)."/vendor/autoload.php";
    use Tienda\Categorias;

    function hayErrores($n, $d){
        $error=false;
        if(strlen($n)==0){
            $_SESSION['error_nombre']="Rellene el campo nombre";
            $error=true;
        }
        if(strlen($d)==0){
            $_SESSION['error_descripcion']="Rellene el campo descripcion";
            $error=true;
        }
        return $error;
    }
    var_dump($_POST);
    if(isset($_POST['btnCrear'])){
        // se procesa el formulario
        var_dump($_POST);
        $nombre=trim(ucwords($_POST['nombre']));
        $descripcion=trim(ucwords($_POST['descripcion']));
        if(!hayErrores($nombre, $descripcion)){
            (new Categorias)->setNombre($nombre)
            ->setDescripcion($descripcion)
            ->create();
            $_SESSION['mensaje']="Categoria creada con exito";
            header("Location:index.php");
            die();
        }else{
            header("Location:{$_SERVER['PHP_SELF']}");
        }
    }else{
    
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
        
        <title>Crear Categoria</title>

    </head>
    <body style="background-color: silver;">
        <h3 class="text-center">Crear Categoria</h3>
        <div class="container mt-2">
            <form name="ccategoria" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="bg-success p-4 text-white rounded shadow-lg m-auto" style="width: 40rem;">
                
                    <div class="mb-3">
                        <label for="n" class="form-label">Nombre Categoria</label>
                        <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" required>
                        <?php 
                            if(isset($_SESSION['error_nombre'])){
                                echo <<< TXT
                                    <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                        {$_SESSION['error_nombre']}
                                    </div>
                                TXT;
                                unset($_SESSION['error_nombre']);
                            }
                        ?>
                    </div>
            
                    <div class="mb-3">
                        <label for="d" class="form-label">Descripcion Categoria</label>
                        <input type="text" class="form-control" id="d" placeholder="Descripcion" name="descripcion" name="d" required>
                        <?php 
                            if(isset($_SESSION['error_descripcion'])){
                                echo <<< TXT
                                    <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                        {$_SESSION['error_descripcion']}
                                    </div>
                                TXT;
                                unset($_SESSION['error_descripcion']);
                            }
                        ?>
                    </div>
                    
                    <div>
                        <button type="submit" name="btnCrear" class="btn btn-info"><i class="fas fa-edit"></i> Crear</button>
                        <button type="reset" class="btn btn-warning"><i class="fas fa-broom"></i> Limpiar</button>
                        <a href="index.php" class="btn btn-info"><i class="fas fa-backward"></i> Volver</a>
                    </div>
                </div>
            </form> 
        </div>
    </body>
</html>
<?php } ?>
<?php
    require dirname(__DIR__, 2)."/vendor/autoload.php";
    use Tienda\Categorias;

    (new Categorias)->generarCategorias(6);
    $stmt=(new Categorias)->readAll();

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
        
        <title>Categorias</title>

    </head>
    <body style="background-color: silver;">
        <h3 class="text-center my-4">Categorias Tienda</h3>
        <div class="container mt-2">
        <a href="ccategoria.php" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Nueva Categoria</a>
        <a href="../" class="btn btn-primary mb-2"><i class="fas fa-backward"></i> Volver</a>
            <table class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th scope="col" style="text-align:center;">Id</th>
                        <th scope="col" style="text-align:center;">Nombre</th>
                        <th scope="col" style="text-align:center;">Descripcion</th>
                        <th scope="col" style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
                            echo <<< TXT
                                <tr>
                                    <td style='text-align:center;'>{$fila->id}</td>
                                    <td style='text-align:center;'>{$fila->nombre}</td>
                                    <td style='text-align:center;'>{$fila->descripcion}</td>
                                    <td>
                                        <form name='s' action='bcategoria.php' method='POST' style='text-align:center;'>
                                            <input type='hidden' name='id' value='{$fila->id}'>
                                            <a href="ucategoria.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea borrar la categoria?')"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            TXT;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
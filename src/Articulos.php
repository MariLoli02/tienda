<?php
    namespace Tienda;
    use PDO;
    use PDOExeception;
    use Faker;
    use Tienda\Categorias;

    class Articulos extends Conexion{
        private $id;
        private $nombre;
        private $precio;
        private $categoria_id;

        public function __construct(){
            parent::__construct();
        }
        //-------------CRUD-----------------
        // Esta funcion me inserta datos en base de datos de articulos
        public function create(){
            $q="insert into articulos(nombre, precio, categoria_id) values (:n, :p, :ci)";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':n'=>$this->nombre,
                    ':p'=>$this->precio,
                    ':ci'=>$this->categoria_id
                ]);
            }catch(PDOExcepcion $ex){
                die("Error al crear Articulos: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }
        // esta funcion recibe una id y lee todos los articulos que coincidan con esa id y me devuelve un articulo con esa id
        public function read($id){
            $q="select * from articulos where id=:i";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
           }catch(PDOException $ex){
               die("Error al eliminar articulos: ".$ex->getMessage());
           }
           parent::$conexion=null;
           return $stmt->fetch(PDO::FETCH_OBJ);
        }
        public function update(){
            $q="update articulos set nombre=:n, precio=:p, categoria_id=:ci where id=:i";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':n'=>$this->nombre,
                    ':p'=>$this->precio,
                    ':ci'=>$this->categoria_id,
                    ':i'=>$this->id 
                ]);
            }catch(PDOException $ex){
                die("Error al actualizar el articulo: ".$ex->getMessage());
            }
            parent::$conexion=null; // cerramos la conexion
        }
        public function delete($id){
            $q="delete from articulos where id=:i";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
           }catch(PDOException $ex){
               die("Error al eliminar articulos: ".$ex->getMessage());
           }
           parent::$conexion=null;
        }
        //---------OTROS METODOS------------
        public function generarArticulos($cantidad){
            if($this->hayArticulos()==0){
                // Si no hay articulos los crea
                $Faker= Faker\Factory::create('es_ES');
                $categorias=(new Categorias)->devolverId();

                for($i=0; $i<$cantidad; $i++){
                    $nombre=$Faker->text(6);
                    $precio=$Faker->randomFloat(2, 10, 50);
                    $categoria_id=$categorias[array_rand($categorias, 1)];

                    (new Articulos)->setNombre($nombre)
                    ->setPrecio($precio)
                    ->setCategoria_id($categoria_id)
                    ->create();
                }
            }
        }

        public function hayArticulos(){
            $q="select * from articulos";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al comprobar si hay Articulos: ".$ex->getMenssage());
            }
            parent::$conexion=null;
            return $stmt->rowCount();
        }

        
        public function readAll(){
            $q="select * from articulos";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al leer: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt;
        }



        //----------------------------------
        /**
         * Get the value of id
         */ 
        public function getId(){
            return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of precio
         */ 
        public function getPrecio()
        {
                return $this->precio;
        }

        /**
         * Set the value of precio
         *
         * @return  self
         */ 
        public function setPrecio($precio)
        {
                $this->precio = $precio;

                return $this;
        }

        /**
         * Get the value of categoria_id
         */ 
        public function getCategoria_id()
        {
                return $this->categoria_id;
        }

        /**
         * Set the value of categoria_id
         *
         * @return  self
         */ 
        public function setCategoria_id($categoria_id)
        {
                $this->categoria_id = $categoria_id;

                return $this;
        }
    }
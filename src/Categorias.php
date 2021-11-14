<?php
    namespace Tienda;
    use Faker;
    use PDO;
    use PDOExeception;

    class Categorias extends Conexion{
        private $id;
        private $nombre;
        private $descripcion;

        public function __construct(){
            parent::__construct();
        }
        //-----------CRUD---------------
        public function create(){
            $q="insert into categorias(nombre, descripcion) values (:n, :d)";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':n'=>$this->nombre,
                    ':d'=>$this->descripcion
                ]);
            }catch(PDOException $ex){
                die("Error al insertar categorias: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }

        public function read($id){
            $q="select * from categorias where id=:i";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al leer id: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function update(){
            $q="update categorias set nombre=:n, descripcion=:d where id=:i";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':n'=>$this->nombre,
                    ':d'=>$this->descripcion,
                    ':i'=>$this->id
                ]);
            }catch(PDOExcepcion $ex){
                die("Error al actualizar categoria: ".$ex->getMessage());
            }
            parent::$conexion==null;
        }

        public function delete($id){
            $q="delete from categorias where id=:i";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al eliminar categorias: ".$ex->getMenssage());
            }
            parent::$conexion=null;
        }
        //--------------OTROS METODOS------------------
        public function generarCategorias($cantidad){
            if($this->hayCategorias()==0){
                $Faker=Faker\Factory::create('es_ES');
                for($i=0; $i<$cantidad; $i++){
                    (new Categorias)->setNombre($Faker->text(10))
                    ->setDescripcion($Faker->text(200))
                    ->create();
                }
            }
        }

        public function hayCategorias(){
            $q="select * from categorias";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al comprobar si hay Categorias: ".$ex->getMenssage());
            }
            parent::$conexion=null;
            return $stmt->rowCount();
        }

        public function devolverId(){
            $q="select id from categorias";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al devolver la id: ".$ex->getMessage());
            }
            $id=[];
            while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
                $id[]=$fila->id;
            }
            parent::$conexion=null;
            return $id;
        }

        public function readAll(){
            $q="select * from categorias";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al leer: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt;

        }

        public function devolverCategorias(){
            $q="select nombre, descripcion, id from categorias";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error en devolver Categorias: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->fetchALl(PDO::FETCH_OBJ);
        }




        //--------------------------------------------

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
        public function setId($id){
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre(){
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre){
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of descripcion
         */ 
        public function getDescripcion(){
                return $this->descripcion;
        }

        /**
         * Set the value of descripcion
         *
         * @return  self
         */ 
        public function setDescripcion($descripcion){
                $this->descripcion = $descripcion;

                return $this;
        }
    }
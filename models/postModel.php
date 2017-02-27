<?php

class postModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getPosts()
    {
//        $post = $this->_db_->query("SELECT * FROM posts");
//        return $post->fetchAll();
    }

    public function getPost($id)
    {
//        $id = (int) $id;
//        $post = $this->_db_->query("SELECT * FROM posts WHERE id=$id");
//        return $post->fetch();
    }

    public function insertarPost($titulo, $cuerpo, $imagen)
    {
//        $this->_db_->prepare("INSERT INTO posts VALUES (null, :titulo, :cuerpo, :imagen)")
//                ->execute(
//                        array(
//                            ':titulo' => $titulo,
//                            ':cuerpo' => $cuerpo,
//                            ':imagen' => $imagen
//        ));
    }

    public function editarPost($id, $titulo, $cuerpo, $imagen)
    {
//        $id = (int) $id;
//        $this->_db_->prepare("UPDATE posts SET titulo= :titulo, cuerpo = :cuerpo, imagen = :imagen WHERE id = :id")
//                ->execute(
//                        array(
//                            ':id' => $id,
//                            ':titulo' => $titulo,
//                            ':cuerpo' => $cuerpo,
//                            ':imagen' => $imagen
//        ));
    }
    
    public function eliminarPost($id)
    {
        
        
    }

    public function temp_insertar_posts($cantidad = 100, $table = 'posts')
    {
//        for ($index = 0; $index < $cantidad; $index++) {
//            $sql = "INSERT INTO $table VALUES(null,'titulo_".$index."','cuerpo_".$index."cuerpo')";
//            $this->_db_->query($sql);
//        }
    }
}
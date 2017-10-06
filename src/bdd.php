<?php

require_once "req_bdd.php";

class bdd
{
    private static $_instance = NULL;

    private $link;

    private function __construct($base){
        // Connexion et sélection de la base
        try{
            $this->link = @new PDO("sqlite:src/".$base);
            $this->link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
    }

    public static function getInstance($base) {

        if(is_null(self::$_instance)) {
            self::$_instance = new bdd($base);
        }
        return self::$_instance;
    }

    public function Get($nom_req,$tab_param=array())
    {
        $stmt = null;
        try{
            $stmt = $this->link->prepare(requete::$req[$nom_req] );
            /*foreach($tab_param as $param => $value){
                $stmt->bindParam($param, $value);
            }*/
            $stmt->execute($tab_param);
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }

        return $stmt->fetchAll();
    }

    public function Count($nom_req,$tab_param=array())
    {
        $stmt = null;
        try{
            $stmt = $this->link->prepare(requete::$req[$nom_req] );
            /*foreach($tab_param as $param => $value){
                $stmt->bindParam($param, $value);
            }*/
            $stmt->execute($tab_param);
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        $res = $stmt->fetchAll();
        return $res[0]["Count(ID)"];
    }

    public function Set($nom_req,$tab_param=array())
    {
      $stmt = null;
      try{
          $stmt = $this->link->prepare(requete::$req[$nom_req] );
          /*foreach($tab_param as $param => $value){
              echo $param." | ".$value."\n";
              $stmt->bindParam($param, $value);
          }*/
          $stmt->execute($tab_param);
      }catch(PDOException  $e ){
          echo "Error: ".$e;
      }
    }
    public function Reset()
    {
      $stmt = null;
      try{
          foreach (requete::$req['reset'] as  $value) {
            $stmt = $this->link->prepare($value );
            $stmt->execute();
          }
      }catch(PDOException  $e ){
          echo "Error: ".$e;
      }
    }
}
?>

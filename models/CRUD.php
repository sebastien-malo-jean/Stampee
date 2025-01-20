<?php
namespace App\Models;

class CRUD extends \PDO {
    final public function __construct() {
        parent::__construct('mysql:host=localhost; dbname=stampee; port=3306; charset=utf8', 'root', '');
    }
    
    /**
     * Cette méthode effectue une requête SELECT sur la table de base de données associée à l'instance de classe.
     * @param mixed $field
     * @param mixed $order
     * @return array|bool
     */
    final public function select($field = null, $order = 'ASC'){
        if($field == null){
            $field = $this->primaryKey;
        }
        $sql = "SELECT * FROM $this->table ORDER BY $field $order";
        if($stmt = $this->query($sql)){
            return $stmt->fetchAll();
        }else{
            return false;
        } 
    }

     /**
      * Ceci déclare une méthode publique nommée selectId() qui prend un paramètre
      * $value. Cette méthode est responsable de la sélection d'un enregistrement
      * dans la table de base de données en fonction de la valeur de la clé primaire.
      * @param mixed $value
      * @return mixed
      */
     public function selectId($value){
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }   
    }

     /**
      * Cette méthode est conçue pour insérer en toute sécurité des données dans
      * une table de base de données à l'aide des $data fournies. Il garantit que
      * seules les colonnes spécifiées dans la propriété fillable sont prises en
      * compte pour empêcher l'insertion de données non autorisées.
      * @param mixed $data
      * @return bool|string
      */
     public function insert($data){
        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);
        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $this->table ($fieldName) VALUES ($fieldValue)";
        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * La méthode unique() vérifie si une valeur donnée pour un champ spécifié
     * dans la table de base de données est unique ou non, renvoyant true si elle
     * est unique et false sinon. Il s'agit d'une méthode courante utilisée lors
     * de la validation des données ou avant d'insérer de nouveaux enregistrements
     * dans une base de données pour garantir l'intégrité des données.
     * @param mixed $field
     * @param mixed $value
     * @return mixed
     */
    public function unique($field, $value){
    $sql = "SELECT * FROM $this->table WHERE $field = :$field";
    $stmt = $this->prepare($sql);
    $stmt->bindValue(":$field", $value);
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count == 1){
        return $stmt->fetch();
    }else{
        return false;
    }  
}

public function update($data, $id){
    if($this->selectId($id)){
        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);

        $fieldName = null;
        foreach($data as $key=>$value){
            $fieldName .=$key."=:".$key.", ";
        }
        $fieldName = rtrim($fieldName, ", ");
        $sql = "UPDATE $this->table SET $fieldName WHERE $this->primaryKey = :$this->primaryKey";
        $data[$this->primaryKey] = $id;
        $query= $this->prepare($sql);
        foreach($data as $key=>$value){
            $query->bindValue(":$key", $value);
        }
        if($query->execute()){
            return true;
        }else{
            return false;
        }
    }
    else{
        return false;
    }
}

public function delete($id){
    if($this->selectId($id)){
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $id);
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
    else{
        return false;
    }
}

}
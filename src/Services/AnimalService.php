<?php
namespace Ifmo\Web\Services;
use Ifmo\Web\Core\Service;
class AnimalService extends Service
{
    const INSERT_SUCCESS = 1;
    const INSERT_ERROR = 0;
    public function getAnimals(){
        $sql='SELECT * FROM animal, category 
        WHERE animal.id_category = category.id_category;';
        return $this->dbConnection->queryAll($sql);
    }
    public function getAnimalsByCategory($categoryName){
        $sql="SELECT a.animal_name, a.age, a.id_animal, c.description, c.name
        FROM animal a 
        LEFT JOIN category c 
        ON a.id_category=c.id_category
        WHERE c.name=:category;";
        $params=['category'=>$categoryName];
        return $this->dbConnection->execute($sql, $params);
    }
    public function getAnimalById($idAnimal){
        $sql='SELECT * FROM animal WHERE id_animal=:id;';
        $params=['id'=>$idAnimal];
        return $this->dbConnection->execute($sql, $params, false);
    }
    public  function addAnimal($animal_data){
        $sql='INSERT INTO animal
          (animal_name, id_category, description, age, passport, vaccination)
          VALUES(:animal_name, :id_category, :description, :age, :passport, :vaccination);';
        // Если константы вынесены в отедльный класс,
        // то обращемся к ним ИмяКласса::ИМЯ_КОНСТАНТЫ
        return $this->dbConnection->executeSql($sql, $animal_data) ? self::INSERT_SUCCESS : self::INSERT_ERROR;
    }
}
<?php

namespace Ifmo\Web\Controllers;

use Ifmo\Web\Core\Controller;
use Ifmo\Web\Core\Request;
use Ifmo\Web\Services\AnimalService;

class AnimalApi extends Controller
{
    private $animalService;
    public function __construct()
    {
        $this->animalService=new AnimalService();
    }

    // вернет всех животных на vue
    public function animals(){
        $animals=$this->animalService->getAnimals();
        // json_decode - преобразование к json строке
        return $this->ajaxResponse(json_encode($animals));
    }
    // доабавляет всех животных
    public function addAnimal(Request $request){
        $animal_data = $request->post();
        $animal_data['passport'] = (int) $animal_data['passport'];
        $animal_data['vaccination'] = (int) $animal_data['vaccination'];
        $answer = $this->animalService->addAnimal($animal_data) ?
            'Животное добавлено' : 'Ошибка добавления';
        return $this->ajaxResponse($answer);
        // метод сервиса на добавление животного в БД
        // отправка ответа на клиент (добавлено или нет)
        // вывод ответа на клиенте (в vue компоненте)
    }
    // изменяет данные по животному
    public  function editAnimal(Request $request){
        $animal_data=$request->post();
    }
}
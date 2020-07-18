<?
namespace Ifmo\Web\Controllers;
use Ifmo\Web\Core\Controller;
use Ifmo\Web\Core\Request;
use Ifmo\Web\Services\AccountService;

class AccountController extends Controller{
    private $accountService;
    public function __construct(){
        $this->accountService=new AccountService();
    }
    // метод, отвечающий за отображение страницы с регистрацией
    public function showRegForm(){
        $content='registration.php';
        $data=[
            'page_title'=>'Регистрация'
        ];
        return $this->generateResponse($content,$data);
    }
    // метод, отвечающий на отправку формы, отвечающий за регистрацию пользователя /registration POST
    public function regUser(Request $request){
        //var_dump($request->post());
        // можно не обращаться к валидации в AccountService, а проверить данные из массива POST до вызова метода addUser
        $content='registration.php';
        $result=$this->accountService->addUser($request->post());
        $data=[
            'page_title'=>'Регистрация',
            'result'=>$result
        ];
        return $this->generateResponse($content, $data);
    }
    public function account(){
        // Чтобы пользователь не набрал в ручную /account
        // проверяем сессию с email - если она пуста,
        // значит он не заходил туда и тогда перенаправляем на главную
        if(!isset($_SESSION['email'])) header('Location: /');
        $content='accaunt.php';
        $data=[
            'page_title'=>'Личный кабинет'
        ];
        return $this->generateResponse($content,$data);
    }

    // метод, отвечающий за авторизацию
    // Login POST
    public function login(Request $request){
        $auth_data=$request->post();
        // валидация
        $result=$this->accountService->auth($auth_data);
        if($result==AccountService::AUTH_OK){
            $_SESSION['email']=$auth_data['email'];
        }
        return $this->ajaxResponse($result);
    }

    public function logout(){
        $_SESSION=[];
        header('Location: /');
    }
}
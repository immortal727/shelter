<?php
namespace Ifmo\Web\Services;

use Ifmo\Web\Core\Service;

class AccountService extends Service {
    const REGISTRATTION_SUCCESS='Регистрация прошла успешно';
    const REGISTRATTION_ERROR='Ошибка регистрации';
    const USER_EXIST='Пользователь с таким логином уже существует';
    const AUTCH_ERROR='Ошибка авторизации';
    const AUTH_OK='Авторизацуия прошла успешно';
    // Переменная которая будет возвращать ошибку валидации
    private $dbConnection;
    public function __construct(){
        $this->dbConnection=DBConnection::getInstance();
       // $this->validator=new Validator();
        // любые методы класса Validator сделать статическими и обращаться
       // к ним при необходимости без создания объекта Validator::имяМетода() 
    }
    public function addUser(array $reg_data){
        // проверка на наличие пользователя в БД (по Email)
        // зашифровать пароль
        // заносим в БД
        // Валидация !!!
        $email=$reg_data['email'];
        if($this->getUser($email)) return self::USER_EXIST;
        $pwd=$reg_data['password'];
        $pwd=password_hash($pwd, PASSWORD_DEFAULT);
        // запись в таблицу 1
        // запись в таблицу 2
        // запись в таблицу 3
        // открыть транзакцию
        // выполнение всех запросов
        // если все хорошо, подтвердить транзакцию
        // если возникли ошибки, откатываем транзакцию к моменту открытия
        
        // user - добавление email + password
        $user_sql="INSERT INTO user(email, hash)
        VALUES (:user_Email, :user_password);";
        // user_info - user_name + phone
        $user_info_sql = 'INSERT INTO user_info (user_name, phone, id_user) VALUES (:user_name, :phone, :id_user);';
        // + массивы с параметрами
        try{
            // начало транзакции
            // метод beginTransaction() объекта PDO открывает транзакцию
            $this->dbConnection->getConnection()->beginTransaction();
            $user_params=[
                'user_Email'=>$email,
                'user_password'=>$pwd
            ];
            // var_dump($user_params);
            $this->dbConnection->executeSql($user_sql, $user_params);

            $user_info_params=[
                'user_name'=>$reg_data['name'],
                'phone'=>$reg_data['phone'],
                // метод lastInsertId объект PDO вовращает
                // последний добавленный PK 
                'id_user'=>$this->dbConnection->getConnection()->lastInsertId()
            ];
            //var_dump($user_info_params);
            $this->dbConnection->executeSql($user_info_sql, $user_info_params);
            
            // подтверждение транзакции
            // метод comit() объекта PDO подтверждает транзакцию (данные записываются в таблицы)
            $this->dbConnection->getConnection()->commit();
            return self::REGISTRATTION_SUCCESS;  
        } 
        // Exception - тип данных
        catch(Exception $exception){
            // откат транзакции (к методу beginTransaction) данные не будут добавлены
            // метод rollBack объекта PDO откатывают транзцакию к вызову метода beginTransaction()
            $this->dbConnection->getConnection()->rollBack();
            return self::REGISTRATTION_ERROR;
        }
    }
    // авторизация пользователя
    public  function auth(array $auth_data){
        $email=$auth_data['email'];
        $pwd=$auth_data['password'];
        $user=$this->getUser($email);
        // можно конкретизировать ответ - ошибка ввода email
        if(!$user) return self::AUTCH_ERROR;
        // password_verify (пароль, зашированный пароль)
        // возвращает true, либо false (если пароли совпали или нет)
        if(!password_verify($pwd, $user['hash'])){
            return self::AUTCH_ERROR;
        }
        return self::AUTH_OK;
    }

    // Так как проверка потребуется еще и при авторизации, 
    // то выносим ее в отдельный метод
    private function getUser($email){
        $sql="SELECT * FROM user WHERE email=:Email_user";
        $user=$this->dbConnection->execute(
            $sql,               ['Email_user'=>$email], 
            false);
       return $user;
    }
}
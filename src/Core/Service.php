<?php
namespace Ifmo\Web\Core;
use Ifmo\Web\Core\DBConnection;
abstract class Service
{
    protected $dbConnection;
    public function  __construct()
    {
        $this->dbConnection=DBConnection::getInstance();
    }
}
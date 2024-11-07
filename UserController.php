<?php
require_once 'UserModel.php';

class UserController
{
    private $model;

    public function __construct($database)
    {
        $this->model = new UserModel($database);
    }

    public function createUser($name, $email, $password)
    {
        return $this->model->createUser($name, $email, $password);
    }

    public function updateUser($id, $name, $email, $password)
    {
        return $this->model->updateUser($id, $name, $email, $password);
    }

    public function deleteUser($id)
    {
        return $this->model->deleteUser($id);
    }
}
?>
<?php

class TerminalController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        require_once __DIR__ . '/../model/TerminalModel.php';
        $this->pdo = $pdo;
        $this->model = new TerminalModel($pdo);
    }

    public function index()
    {
        return $this->model->getAllTerminals();
    }

    public function createTerminal($data)
    {
        return $this->model->createTerminal($data);
    }

    public function getTerminalById($id)
    {
        return $this->model->getTerminalById($id);
    }

    public function updateTerminal($id, $data)
    {
        return $this->model->updateTerminal($id, $data);
    }

    public function deleteTerminal($id)
    {
        return $this->model->deleteTerminal($id);
    }
}

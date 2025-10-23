<?php
namespace MyProject\controllers;

use MyProject\core\http\Request;
use MyProject\core\http\Response;
use MyProject\services\PersonService;

class PersonApiController {
    private PersonService $service;

    public function __construct() {
        $this->service = new PersonService();
    }

    public function listAll(Request $request) {
        $persons = $this->service->listAllPerson();
        return Response::success($persons);
    }

/*     public function show(Request $request) {
        $id = $request->param('id');

        if (!is_numeric($id)) {
            return Response::error("ID inválido", 422);
        }

        $person = $this->service->findPerson($id);

        if (!$person) {
            return Response::error("Pessoa não encontrada", 404);
        }

        return Response::success($person);
    }

    public function create(Request $request) {
        $data = $request->all();

        if (empty($data['name'])) {
            return Response::error("Nome é obrigatório", 400);
        }

        $created = $this->service->createPerson($data);
        return Response::success($created, 201);
    }

    public function delete(Request $request) {
        $id = $request->param('id');

        if (!$this->service->deletePerson($id)) {
            return Response::error("Pessoa não encontrada ou não deletada", 404);
        }

        return Response::success("Pessoa deletada com sucesso");
    } */
}
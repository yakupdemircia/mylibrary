<?php

namespace App\Http\Repositories;

interface CategoryRepositoryInterface
{

    public function getById($id);

    public function getBySlug($slug = null);

    public function getAll();

    public function getAjaxDatatableDataPaginated($limit = 15);

    public function updateData($id, $data);

    public function createData($data);

}

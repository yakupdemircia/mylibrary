<?php

namespace App\Http\Controllers\Panel;

use App\Http\Repositories\PublisherRepositoryInterface;
use App\Models\Publisher;
use Cache;
use Request;

class PublisherController
{
    protected $repository;
    protected $model;
    protected $route_string = 'publisher';

    public function __construct(PublisherRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new Publisher();
    }

    public function index()
    {

        return view("panel.pages.{$this->route_string}.list");
    }

    public function edit($id)
    {

        $data = $this->repository->getById($id);


        return view("panel.pages.{$this->route_string}.edit")
            ->with('id', $id)
            ->with('data', $data)
            ->with('route', route("panel.{$this->route_string}.update", ['id' => $id]))
            ->with('head', 'Edit');
    }

    public function new()
    {

        return view("panel.pages.{$this->route_string}.edit")
            ->with('data', null)
            ->with('route', route("panel.{$this->route_string}.create"))
            ->with('head', 'Add');
    }

    public function create()
    {

        $data = [
            'title'          => request()->input('title'),
            'description'    => request()->input('description'),
        ];

        $rules = [
            'title'     => 'required',
        ];

        $validator = validator(request()->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $this->repository->createData($data);

            return redirect()
                ->route("panel.{$this->route_string}.new")
                ->with(['success' => 'Saved.']);
        }

    }

    public function update($id)
    {

        $data = [
            'title'       => request()->input('title'),
            'description' => request()->input('description'),
        ];

        if (!is_null(request()->input('pass'))) {
            $data['password'] = bcrypt(request()->input('pass'));
        }

        $rules = [
            'title'  => 'required',
        ];

        $validator = validator(request()->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $this->repository->updateData($id, $data);

            return redirect()
                ->route("panel.{$this->route_string}.edit", ['id' => $id])
                ->with(['success' => 'Updated.']);
        }

    }

    public function delete($id)
    {

        $answer = $this->model->find($id);

        if (is_null($answer)) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Not found!',
            ], 400);
        }

        $answer->delete();

        return response()->json([
            'status'  => 'success',
            'message' => "Item #$id deleted!",
        ]);
    }

    public function getAjaxAll()
    {

        $response = $this->repository->getAjaxDatatableDataPaginated();

        return response()->json($response);
    }

}

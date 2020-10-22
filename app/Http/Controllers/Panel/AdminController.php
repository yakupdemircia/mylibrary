<?php

namespace App\Http\Controllers\Panel;

use App\Models\Admin;
use App\Http\Repositories\AdminRepositoryInterface;
use Cache;
use Request;

class AdminController
{
    protected $repository;
    protected $model;
    protected $route_string = 'admin';

    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new Admin;
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
            'name'     => request()->input('name'),
            'email'    => request()->input('email'),
            'password' => bcrypt(request()->input('password')),
            'phone'    => request()->input('phone'),
            'status'   => request()->input('status') == 'on' ? 1 : 0,
        ];

        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
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
            'name'   => request()->input('name'),
            'email'  => request()->input('email'),
            'phone'  => request()->input('phone'),
            'status' => request()->input('status') == 'on' ? 1 : 0,
        ];

        if (!is_null(request()->input('pass'))) {
            $data['password'] = bcrypt(request()->input('pass'));
        }

        $rules = [
            'email' => 'required|email',
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

<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;
use App\Http\Repositories\UserRepositoryInterface;
use Cache;
use Request;

class UserController
{
    protected $repository;
    protected $model;
    protected $route_string = 'user';

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new User;
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
            'bio'      => request()->input('bio'),
            'phone'    => request()->input('phone'),
            'birthday' => request()->input('birthday'),
            'status'   => request()->input('status') == 'on' ? 1 : 0,
        ];

        $rules = [
            'name'     => 'required',
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
            'name'     => request()->input('name'),
            'email'    => request()->input('email'),
            'bio'      => request()->input('bio'),
            'phone'    => request()->input('phone'),
            'birthday' => request()->input('birthday'),
            'status'   => request()->input('status') == 'on' ? 1 : 0,
        ];

        if (!is_null(request()->input('pass'))) {
            $data['password'] = bcrypt(request()->input('pass'));
        }

        $rules = [
            'name'  => 'required',
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

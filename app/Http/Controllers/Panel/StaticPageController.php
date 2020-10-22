<?php

namespace App\Http\Controllers\Panel;

use App\Http\Repositories\StaticPageRepositoryInterface;
use App\Models\StaticPage;
use Cache;
use Request;

class StaticPageController
{
    protected $repository;
    protected $model;
    protected $route_string = 'static_page';

    public function __construct(StaticPageRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new StaticPage();
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

        $currentSequence = $this->model->getCurrentSequence();

        return view("panel.pages.{$this->route_string}.edit")
            ->with('data', null)
            ->with('current_sequence', $currentSequence)
            ->with('route', route("panel.{$this->route_string}.create"))
            ->with('head', 'Add');
    }

    public function create()
    {

        $data = [
            'title'    => request()->input('title'),
            'desc'     => request()->input('desc'),
            'sequence' => request()->input('sequence'),
        ];

        $rules = [
            'title' => 'required',
            'desc'  => 'required',
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
            'title'    => request()->input('title'),
            'desc'     => request()->input('desc'),
            'sequence' => request()->input('sequence'),
        ];

        $rules = [
            'title' => 'required',
            'desc'  => 'required',
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

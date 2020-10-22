<?php

namespace App\Http\Repositories;

use App\Models\Issue;

class IssueRepository implements IssueRepositoryInterface
{
    private $model;
    private $route_string = 'issue';

    public function __construct()
    {
        $this->model = new Issue();
    }

    public function getById($id = null)
    {
        return $this->model->findOrFail($id);
    }

    public function getBySlug($slug = null)
    {
        return $this->model->getBySlug($slug);
    }

    public function getAll()
    {
        return $this->model->getAll();
    }

    public function getAjaxDatatableDataPaginated($limit = 10000)
    {

        if (request()->has('query')) {
            $this->model->search(request()->input('query'));
        }

        if (request()->has('status')) {
            $this->model->where('status', request()->input('status'));
        }

        $results = $this->model->paginate($limit);

        $response = [
            'draw' => request()->input('draw'),
            'published' => request()->input('published'),
            'status' => request()->input('status'),
            'start' => request()->input('start'),
            'page' => ((int)request()->input('start') / $limit) + 1,
            'recordsFiltered' => $results->total(),
            'recordsTotal' => $results->total(),
            'links' => $results->links(),
            'data' => [],
        ];

        $x = 1;
        foreach ($results as $result) {

            $actions = '<div class="list-action">' .
                '<a class="btn btn-danger delete-btn" 
                       data-return-path="' . route("panel.{$this->route_string}.list") . '"
                       data-id="' . $result->id . '"
                       data-type="' . $this->route_string . '"
                       ><span class="fas fa-trash"></span></a>' .
                '<a class="btn btn-primary btn-xs" style="margin-left:7px;" 
                       href="' . route("panel.{$this->route_string}.edit", $result->id) . '"
                       ><span class="fas fa-edit"></span></a>' .

                '</div>';

            $status = 'waiting';

            if (!$result->return_date) {
                if (strtotime(date('Y-m-d')) > strtotime($result->end_date)) {
                    $status = 'delayed';
                }
            } else {
                $status = 'returned';

                if (strtotime($result->return_date) > strtotime($result->end_date)) {
                    $status = 'returned / delay';
                }

            }

            $response['data'][] = [
                'order'         => ($response['start'] * $limit) + $x,
                'id'            => $result->id,
                'user_name'     => $result->user()->name,
                'book_name'     => $result->book()->title,
                'start_date'    => date_locale($result->start_date),
                'end_date'      => date_locale($result->end_date),
                'return_date'   => $result->return_date,
                'status'        => $status,
                'action'        => $actions,
            ];

            $x++;
        }

        return $response;

    }

    public function updateData($id, $data = [])
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function createData($data = [], $default_options = [], $available_options = [])
    {
        return $this->model->create($data);
    }
}

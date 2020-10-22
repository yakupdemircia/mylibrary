<?php

namespace App\Http\Repositories;

use App\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    private $model;
    private $route_string = 'book';

    public function __construct()
    {
        $this->model = new Book();
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

    public function getAjaxDatatableDataPaginated_old($limit = 10000)
    {
        $limit = request()->input('length');

        if (request()->has('search') && request()->input('search')['value']) {
            $results = $this->model->search(request()->input('search')['value'],request()->input('start'),$limit);
        }else{
            if (request()->has('status')) {
                $this->model->where('status', request()->input('status'));
            }

            $results = $this->model->paginate($limit);
        }

        $response = [
            'draw'            => request()->input('draw'),
            'published'       => request()->input('published'),
            'status'          => request()->input('status'),
            'start'           => request()->input('start'),
            'page'            => (int)(request()->input('start') / $limit) + 1,
            'recordsFiltered' => $results->total(),
            'recordsTotal'    => $results->total(),
            'links'           => $results->links()->elements,
            'data'            => [],
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

            $response['data'][] = [
                'order'      => ($response['start'] * $limit) + $x,
                'id'         => $result->id,
                'category'   => $result->category()->first()->title,
                'publisher'  => $result->publisher()->first()->title,
                'author'     => $result->author()->first()->name,
                'title'      => $result->title,
                'stock'      => $result->stock,
                'in_rent'    => 0,
                'action'     => $actions,
            ];

            $x++;
        }

        return $response;

    }

    public function getAjaxDatatableDataPaginated($limit = 10000)
    {
        $draw = request()->input('draw');
        $start = request()->input("start");
        $rowperpage = request()->input("length"); // Rows display per page

        $query = request()->input('search')['value']; // Search value

        if($query){
            $results = $this->model->search($query)->paginate((int)$rowperpage,'page',($start/$rowperpage));
        }else{
            $results = $this->model->paginate($rowperpage);
        }


        $data_arr = array();
        foreach($results->items() as $result){

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

            $data_arr[] = array(
                "id" => $result->id,
                "title" => $result->title,
                "category" => $result->category()->title,
                "author" => $result->author()->name,
                "publisher" => $result->publisher()->title,
                "action" => $actions,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => Book::all()->count(),
            "recordsFiltered" => $results->total(),
            "zzz" => ($start/$rowperpage),
            "data" => $data_arr
        );

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
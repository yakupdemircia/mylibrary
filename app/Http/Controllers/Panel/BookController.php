<?php

namespace App\Http\Controllers\Panel;
use App\Http\Repositories\BookRepositoryInterface;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Cache;
use Request;

class BookController
{
    protected $repository;
    protected $model;
    protected $route_string = 'book';

    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new Book();
    }

    public function index()
    {

        return view("panel.pages.{$this->route_string}.list");
    }

    public function edit($id)
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        $data = $this->repository->getById($id);

        return view("panel.pages.{$this->route_string}.edit")
            ->with('id', $id)
            ->with('data', $data)
            ->with('publishers',$publishers)
            ->with('authors',$authors)
            ->with('categories',$categories)
            ->with('route', route("panel.{$this->route_string}.update", ['id' => $id]))
            ->with('head', 'Edit');
    }

    public function new()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view("panel.pages.{$this->route_string}.edit")
            ->with('data', null)
            ->with('publishers',$publishers)
            ->with('authors',$authors)
            ->with('categories',$categories)
            ->with('route', route("panel.{$this->route_string}.create"))
            ->with('head', 'Add');
    }

    public function create()
    {

        if (request()->has('excel_file')) {

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadsheet = $reader->load($_FILES['excel_file']['tmp_name']);

            $worksheet = $spreadsheet->getActiveSheet();

            $rows = [];

            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(TRUE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }


            for ($i = 1; $i < count($rows); $i++) {

                $row = $rows[$i];

                //if no category present on excel file
                if(empty($row[3])){
                    $row[3] = 'No Category';
                }
                //if no author present on excel file
                if(empty($row[5])){
                    $row[5] = 'No Author';
                }

                //if no author present on excel file
                if(empty($row[6])){
                    $row[6] = 'No Publisher';
                }

                $category = Category::where('title',ucwords(mb_strtolower($row[3])))->first();

                if(!$category){
                    $category = Category::create([
                        'title' => ucwords(mb_strtolower($row[3])),
                        'description' => ''
                    ]);
                }

                $author = Author::where('name',ucwords(mb_strtolower($row[5])))->first();

                if(!$author){
                    $author = Author::create([
                        'name' => ucwords(mb_strtolower($row[5])),
                    ]);
                }

                $publisher = Publisher::where('title', ucwords(mb_strtolower($row[6])))->first();

                if (!$publisher) {

                    $publisher = Publisher::create([
                            'title' => ucwords(mb_strtolower($row[6])),
                            'description' => ''
                    ]);
                }

                $book = Book::create([
                    'isbn'         => $row[1],
                    'image'        => '',
                    'title'        => $row[4],
                    'category_id'  => $category->id,
                    'author_id'    => $author->id,
                    'publisher_id' => $publisher->id,
                    'edition'      => $row[7],
                    'cost'         => floatval($row[9]),
                    'purchase_date'=> \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[8]),
                    'description'         => $row[10],
                    'stock'        => $row[11],
                    'status'       => 1,
                ]);

            }

            return redirect(route('panel.book.list'));
        }


        $data = [
            'isbn'         => request()->input('isbn'),
            'title'        => request()->input('title'),
            'image'        => request()->input('image'),
            'category_id'  => request()->input('category_id'),
            'author_id'    => request()->input('author_id'),
            'publisher_id' => request()->input('publisher_id'),
            'edition'      => request()->input('edition'),
            'cost'         => request()->input('cost'),
            'description'  => request()->input('desc'),
            'stock'        => request()->input('stock'),
            'status'       => request()->input('status') == 'on' ? 1 : 0,
        ];

        $rules = [
            'title'         => 'required',
            'category_id'   => 'required',
            'publisher_id'  => 'required',
            'author_id'     => 'required',
            'stock'         => 'required|integer',
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
            'isbn'         => request()->input('isbn'),
            'title'        => request()->input('title'),
            'image'        => request()->input('image'),
            'category_id'  => request()->input('category_id'),
            'author_id'    => request()->input('author_id'),
            'publisher_id' => request()->input('publisher_id'),
            'edition'      => request()->input('edition'),
            'cost'         => request()->input('cost'),
            'description'  => request()->input('desc'),
            'stock'        => request()->input('stock'),
            'status'       => request()->input('status') == 'on' ? 1 : 0,
        ];

        $rules = [
            'title'         => 'required',
            'category_id'   => 'required',
            'publisher_id'  => 'required',
            'author_id'     => 'required',
            'stock'         => 'required|integer',
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

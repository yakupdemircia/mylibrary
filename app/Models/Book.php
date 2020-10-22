<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Book extends Model
{
    protected $guarded = [];

    use Searchable;

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'isbn' => $this->isbn,
            'author' => $this->author()->name,
            'publisher' => $this->publisher()->title,
            'description' => $this->description,
        ];
    }

    public function publisher(){
        return $this->belongsTo(Publisher::class)->first();
    }

    public function author()
    {
        return $this->belongsTo(Author::class)->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->first();
    }

    /*public function search($query,$start,$rowPerPage,$columnName,$columnSortOrder)
    {
        return [
        'totalRecords' => Book::select('count(*) as allcount')->count(),
        'filteredRecords' => Book::select('count(*) as allcount')->where('title', 'like', '%' .$query . '%')->count(),
        'records' => Book::orderBy($columnName,$columnSortOrder)
            ->where('books.title', 'like', '%' .$query . '%')
            ->select('books.*')
            ->skip($start)
            ->take($rowPerPage)
            ->get()
        ];

    }*/

    public function searchBook($query,$page,$limit) : array
    {
        $query = convert_search_word_by_word($query);

        $total_count = DB::select("SELECT count(*) as cnt
                            FROM books as b 
                            INNER JOIN categories as c ON c.id=b.category_id
                            INNER JOIN authors as a ON a.id=b.author_id
                            INNER JOIN publishers as p ON p.id=b.publisher_id
                            WHERE b.title REGEXP '$query' OR b.isbn REGEXP '$query' OR a.name REGEXP '$query' OR c.title REGEXP '$query' OR p.title REGEXP '$query'
                            "
        )[0]->cnt;

        $books =  DB::select("SELECT b.id, b.description, b.title, b.isbn, a.name as author,c.title as category, p.title as publisher 
                            FROM books as b 
                            INNER JOIN categories as c ON c.id=b.category_id
                            INNER JOIN authors as a ON a.id=b.author_id
                            INNER JOIN publishers as p ON p.id=b.publisher_id
                            WHERE b.title REGEXP '$query' OR b.isbn REGEXP '$query' OR a.name REGEXP '$query' OR c.title REGEXP '$query' OR p.title REGEXP '$query'
                            LIMIT {$limit} OFFSET ".$page * $limit
                            );

        return array(
            'books' => $books,
            'total_count' => $total_count
        );
    }

}
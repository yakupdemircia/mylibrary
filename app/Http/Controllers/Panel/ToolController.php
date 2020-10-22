<?php

namespace App\Http\Controllers\Panel;

class ToolController
{
    protected $repository;
    protected $model;

    public function __construct()
    {
    }

    public function index()
    {

        return view("panel.pages.tool.index");
    }

}


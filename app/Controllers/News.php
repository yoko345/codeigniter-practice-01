<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends Controller
{
    public function index()
    {
        $model = model(NewsModel::class);
        $data = [
            "news_list" => $model->getNews(),
            "title" => "News archive",
        ];

        return view("templates/header", $data)
            . view("news/index", $data)
            . view("templates/footer", $data);
    }

    public function view($slug = null)
    {
        $model = model(NewsModel::class);
        $data["news"] = $model->getNews($slug);
        if ($data["news"] === null) {
            throw new PageNotFoundException("Cannot find the news item: "  . $slug);
        }
        $data["title"] = $data["news"]["title"];
        return view("templates/header", $data)
            . view("news/view", $data)
            . view("templates/footer", $data);
    }
}

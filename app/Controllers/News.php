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

    public function new()
    {
        helper("form");

        return view("templates/header", ["title" => "Create a news item"])
            . view("news/create")
            . view("templates/footer");
    }

    public function create()
    {
        helper("form");

        $data = $this->request->getPost(["title", "body"]);

        if (!$this->validateData($data, [
            "title" => "required|max_length[255]|min_length[3]",
            "body" => "required|max_length[5000]|min_length[10]",
        ])) {
            return $this->new();
        }

        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);

        $model->save([
            "title" => $post["title"],
            "slug" => url_title($post["title"], "-", true),
            "body" => $post["body"],
        ]);

        return view("templates/header", ["title" => "Create a news item"])
            . view("news/success")
            . view("templates/footer");
    }
}

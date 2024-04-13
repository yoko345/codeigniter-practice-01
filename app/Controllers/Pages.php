<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function view(string $page = "home")
    {
        if (! is_file(APPPATH . "Views/pages/" . $page . ".php")) {
            throw new PageNotFoundException($page);
        }
        $data["title"] = ucfirst($page);

        return view("templates/header", $data)
        . view("pages/" . $page, $data)
        . view("templates/footer", $data);
    }
}

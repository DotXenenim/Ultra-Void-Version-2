<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class HomeController
{
    public function __construct(private ResponseFactory $responseFactory)
    {
    }

    public function index(Request $request): Response
    {
        return $this->responseFactory->view('home.html.twig');
    }
}

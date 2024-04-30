<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function index(Page $page)
    {
        if (! $page->isPublished()) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('pages.index', [
            'page' => $page,
            'title' => $page->title,
        ]);
    }
}

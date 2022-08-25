<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Page $page){

        //Page meta data
        $meta = new Meta([
            'title' => $page->title,
            'description' => $page->seo['description'] ?? $page->title,
            'keywords' => $page->seo['keywords'] ?? $page->title,
        ]);
        if($page->seo['image']) {
            $meta->image = storage_url($page->seo['image']);
        }

        return view('Frontend.Page.index', compact('page'));
    }
}

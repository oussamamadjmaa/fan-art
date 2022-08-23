<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function show(News $blog) {
        abort_if($blog->status != News::PUBLISHED || !$blog->user, 404);

        //Page meta data
        $meta = new Meta([
            'title' => $blog->title,
            'description' => $blog->seo['description'] ?? $blog->title,
            'keywords' => $blog->seo['keywords'] ?? $blog->title,
            'image'    => storage_url($blog->image)
        ]);

        return view('Frontend.Blogs.show', compact('blog'));
    }
}

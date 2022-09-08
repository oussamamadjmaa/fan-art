<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index(){
        //Page meta data
        $meta = new Meta([
            'title' => __('Artist blog'),
        ]);

        $artists_with_last_blog = User::role('artist')->activeSubscribedArtist()
            ->withWhereHas('latest_blog')
            ->paginate(16);

        return view('Frontend.Blogs.index', compact('artists_with_last_blog'));
    }
    public function show(News $blog) {
        $blog->load(['user' => fn($q) => $q->activeSubscribedArtist()]);
        abort_if(!$blog->user, 404);
        abort_if($blog->status != News::PUBLISHED || !$blog->user, 404);

        //Page meta data
        $meta = new Meta([
            'title' => $blog->title,
            'description' => $blog->seo['description'] ?? $blog->title,
            'keywords' => $blog->seo['keywords'] ?? $blog->title,
            'image'    => storage_url($blog->image)
        ]);

        //Visits count
        if(!auth()->check() || auth()->id() != $blog->user_id){
            $visits = $blog->visits()->firstOrCreate(['visits_date' => now()->format('Y-m-d')], ['count' => 0]);
            $visits->increment('count');
        }

        return view('Frontend.Blogs.show', compact('blog'));
    }
}

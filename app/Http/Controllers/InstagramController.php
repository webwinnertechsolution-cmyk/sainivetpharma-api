<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class InstagramController extends Controller
{
    public function index()
    {
        $data = Cache::remember('insta_feed', 3600, function () {
            $response = Http::get('https://feeds.behold.so/vXQ5XepduZCxb0ppvQDI');
            return $response->json();
        });

        $posts = $data['posts'] ?? [];

        return view('instagram', compact('posts'));
    }
}

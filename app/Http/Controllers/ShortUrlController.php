<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenUrlRequest;
use App\Models\ShortUrl;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{

    public function index()
    {
        $urls = ShortUrl::orderby('clicks', 'desc')->paginate(10);
        return Inertia::render('UrlShortener/Create', compact('urls'));
    }

    public function store(ShortenUrlRequest $request)
    {
        $url = $request->validated();

        // get the url element from the validated request
        $url = $url['url'];

        // parse the url
        $url = parse_url($url);

        // get the path from the url if it exists
        $path = $url['path'] ?? '';
        $path = $path === '/' ? str_replace('/', '', $path) : $path;

        // get the query string from the url if it exists
        $query = $url['query'] ?? '';
        $query = $query === '' ? str_replace('?', '', $query) : $query;
        $query = $query === '' ? '' : '?' . $query;

        // recreate the url with a fixed format (https://www.example.com)
        $url =  $url['scheme'] . '://' . $url['host'] . $path . $query;

        // add www if it's not there
        if (strpos($url, 'www') === false) {
            $url = str_replace('://', '://www.', $url);
        }

        $oldUrl = ShortUrl::where('url', $url)->first();

        if ($oldUrl) {
            $urls = ShortUrl::orderby('clicks', 'desc')->paginate(10);
            $url = request()->getSchemeAndHttpHost() . '/' . $oldUrl->code;
            return Inertia::render('UrlShortener/Create', compact('url', 'urls'));
        }

        $newUrl = ShortUrl::create([
            'url' => $url,
            'code' => Str::random(4)
        ]);

        $urls = ShortUrl::orderby('clicks', 'desc')->paginate(10);
        $url = request()->getSchemeAndHttpHost() . '/' . $newUrl->code;

        return Inertia::render('UrlShortener/Create', compact('url', 'urls'));
    }

    public function redirect($code)
    {
        $url = ShortUrl::where('code', $code)->firstOrFail();

        $url->increment('clicks');

        try {
            get_headers($url->url);
        } catch (\Exception $e) {
            $url->url = str_replace('://www.', '://', $url->url);
            return redirect($url->url);
        }

        return redirect($url->url);
    }
}

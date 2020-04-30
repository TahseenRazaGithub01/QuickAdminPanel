<?php 
    echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
?>

    <url>
        <loc>{{ config('app.app_path') }}</loc>
        <lastmod>{{ date("Y-m-d") . 'T' . date("H:i:s") . '+00:00' }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
    </url>

        @if(isset($stores))
            @foreach($stores as $item)
            <url>
                <loc>{!! config('app.app_path').'/'.$item['slugs']['slug'] !!}</loc>
                <lastmod>{{ date("Y-m-d") . 'T' . date("H:i:s") . '+00:00' }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
            @endforeach
        @endif

        @if(isset($blog))
            @foreach($blog as $item)
            <url>
                <loc>{!! config('app.app_path').'/'.$item['slugs']['slug'] !!}</loc>
                <lastmod>{{ date("Y-m-d") . 'T' . date("H:i:s") . '+00:00' }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
            @endforeach
        @endif

        @if(isset($categories))
            @foreach($categories as $item)
            <url>
                <loc>{!! config('app.app_path').'/'.$item['slugs']['slug'] !!}</loc>
                <lastmod>{{ date("Y-m-d") . 'T' . date("H:i:s") . '+00:00' }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
            @endforeach
        @endif

        @if(isset($events))
            @foreach($events as $item)
            <url>
                <loc>{!! config('app.app_path').'/'.$item['slugs']['slug'] !!}</loc>
                <lastmod>{{ date("Y-m-d") . 'T' . date("H:i:s") . '+00:00' }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.6</priority>
            </url>
            @endforeach
        @endif

        @if(isset($pages))
            @foreach($pages as $item)
            <url>
                <loc>{!! config('app.app_path').'/'.$item['slugs']['slug'] !!}</loc>
                <lastmod>{{ date("Y-m-d") . 'T' . date("H:i:s") . '+00:00' }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.5</priority>
            </url>
            @endforeach
        @endif


</urlset>

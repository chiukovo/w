<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach ($urls as $urlData)
    <url>
        <loc>{{ $urlData['loc'] }}</loc>
        <lastmod>{{ $urlData['lastmod'] }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>

        <!-- 可選 hreflang，預設單語系 -->
        <xhtml:link rel="alternate" hreflang="zh-Hant" href="{{ $urlData['loc'] }}" />
    </url>
    @endforeach
</urlset>

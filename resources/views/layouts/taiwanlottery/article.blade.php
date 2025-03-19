@php
use App\Models\Article;
$articles = Article::limit(5)->orderBy('published_at')->get()->toArray();
@endphp

<div class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl p-4 sm:p-8 mb-10">
    <h2 class="text-2xl font-bold mb-6">熱門文章</h2>
    <div class="space-y-6">
        @foreach($articles as $article)
        <div class="hover:bg-gray-50 p-4 rounded-xl transition cursor-pointer">
            <a href="/taiwanlottery/articles/{{ $article['slug'] }}">
                <h3 class="text-lg font-semibold mb-1 hover:underline">{{ $article['title'] }}</h3>
                <p class="text-sm text-gray-600">{{ $article['category'] }}分析/模擬/建議</p>
                <span class="text-xs text-gray-400 block mt-2">{{ \Carbon\Carbon::parse($article['published_at'])->format('Y-m-d') }}</span>
            </a>
        </div>
        @endforeach
    </div>

    <!-- 更多文章按鈕 -->
    <div class="mt-8 text-center">
        <a href="/taiwanlottery/articles" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-6 rounded-full transition">查看更多文章</a>
    </div>
</div>
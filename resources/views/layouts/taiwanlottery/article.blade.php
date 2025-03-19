@php
use App\Models\Article;
$articles = Article::limit(5)->orderBy('published_at')->get()->toArray();
@endphp

<div class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl p-4 sm:p-8 mb-10">
    <h2 class="text-2xl font-bold mb-6">熱門文章</h2>
    <div class="space-y-6">
        @foreach($articles as $article)
        <div class="hover:bg-gray-50 p-4 rounded-xl transition cursor-pointer">
            <a href="/taiwanlottery/article/{{ $article['id'] }}"><h3 class="text-lg font-semibold mb-1 hover:underline">{{ $article['title'] }}</h3>
            <p class="text-sm text-gray-600">{{ $article['category'] }}分析/模擬/建議</p>
            <span class="text-xs text-gray-400 block mt-2">{{ $article['published_at'] }}</span></a>
        </div>
        @endforeach
    </div>
</div>
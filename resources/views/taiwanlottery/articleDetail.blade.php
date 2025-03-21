<!DOCTYPE html>
<html lang="zh-TW">
  @include('layouts.taiwanlottery.main', [
      'title' => $article['title'] . ' | 彩券模擬分析',
      'description' => Str::limit(strip_tags($article['content']), 120),
      'keywords' => $article['category'] . ', 威力彩, 大樂透, 今彩539, 彩券攻略, 模擬下注',
      'og_title' => $article['title'] . ' | 彩券模擬分析',
      'og_description' => Str::limit(strip_tags($article['content']), 120),
  ])
  <body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <div id="app" v-cloak>
      @include('layouts.taiwanlottery.header')
      <div class="max-w-7xl mx-auto px-4">
        <!-- 文章內文 -->
        <div class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl p-4 sm:p-8 mb-10 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-4 text-blue-700">{{ $article['title'] }}</h2>
            <div class="text-center text-sm text-gray-500 mb-6">
                📌 分類：{{ $article['category'] }} ｜ 🕒 發佈時間：{{ \Carbon\Carbon::parse($article['published_at'])->format('Y-m-d') }}
            </div>
            <div class="prose max-w-none">
                {!! $article['content'] !!}
            </div>
    
            <!-- 同分類推薦文章 -->
            <div class="mt-12 pt-6 border-t border-gray-200">
                <h4 class="text-lg font-semibold mb-4 text-blue-700">🔎 同分類推薦文章</h4>
                <ul class="space-y-3">
                    @foreach($relatedArticles as $rel)
                        <li>
                            <a href="/taiwanlottery/articles/{{ $rel->slug }}" class="flex justify-between items-center group">
                                <span class="text-blue-600 font-medium group-hover:underline block truncate">{{ $rel->title }}</span>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($rel->published_at)->format('Y-m-d') }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
    
            <div class="mt-10 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-6 text-sm text-yellow-800 flex items-center gap-2">
              <a href="/taiwanlottery">
                🚀 喜歡這篇文章嗎？分享給朋友，或試試我們的彩券模擬器吧！🎯
              </a>
            </div>
    
            @include('layouts.taiwanlottery.share')
    
            <!-- 返回 & 模擬按鈕 -->
            <div class="mt-6 text-center flex justify-center gap-4 flex-wrap">
              <a href="/taiwanlottery/articles" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-6 rounded-full transition">
                ⬅ 返回文章列表
              </a>
              <a href="/" 
                class="inline-block bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold py-2 px-6 rounded-full transition">
                🎲 模擬下注玩看看
              </a>
            </div>
        </div>
    
        @include('layouts.taiwanlottery.footer')
    </div>
        
    </div>

    <script>
      const { createApp } = Vue;
      createApp({
        setup() {
          function switchGame(game) {
              if (game == '威力彩') {
                  location.href = '/';
              } else if (game == '今彩539') {
                  location.href = '/taiwanlottery/539';
              } else if (game == '大樂透') {
                  location.href = '/taiwanlottery/lotto';
              }
          }
          return { switchGame };
        }
      }).mount('#app');
    </script>
  </body>
</html>

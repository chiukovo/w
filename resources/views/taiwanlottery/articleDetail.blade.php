<!DOCTYPE html>
<html lang="zh-TW">
  @include('layouts.taiwanlottery.main')
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
                    
            <!-- 返回 & 模擬按鈕 -->
            <div class="mt-10 text-center flex justify-center gap-4 flex-wrap">
              <a href="/taiwanlottery/articles" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-6 rounded-full transition">
                ⬅ 返回文章列表
              </a>
              <a href="/taiwanlottery" 
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
                  location.href = '/taiwanlottery';
              } else if (game == '今彩539') {
                  location.href = '/taiwanlottery/539';
              }
          }
          return { switchGame };
        }
      }).mount('#app');
    </script>
  </body>
</html>

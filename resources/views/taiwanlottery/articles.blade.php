<!DOCTYPE html>
<html lang="zh-TW">
  @include('layouts.taiwanlottery.main', [
    'title' => '彩券攻略文章 | 威力彩、大樂透、今彩539 模擬分析',
    'description' => '精選彩券相關文章，包含威力彩、大樂透、今彩539、雙贏彩的模擬下注、統計分析、玩法攻略，助你彩券投注更有依據！',
  ])

  <body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <div id="app" v-cloak>
      @include('layouts.taiwanlottery.header')
      <div class="max-w-7xl mx-auto px-4">

        <!-- 文章列表 -->
        <div class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl p-4 sm:p-8 mb-10">
          <h2 class="text-3xl font-bold text-center mb-8 text-blue-700">🔥 熱門文章推薦</h2>
          
          <div class="grid sm:grid-cols-2 gap-6">
              @foreach($articles['data'] as $article)
              <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition">
                  <a href="/taiwanlottery/articles/{{ $article['slug'] }}" class="block">
                      <h3 class="text-xl font-semibold mb-2 hover:text-blue-600 transition">{{ $article['title'] }}</h3>
                      <p class="text-sm text-gray-600 mb-3">📌 分類：{{ $article['category'] }} | 模擬 / 建議</p>
                      <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($article['published_at'])->format('Y-m-d') }}</p>
                  </a>
              </div>
              @endforeach
          </div>

          <!-- 分頁 -->
          <div class="mt-10 flex justify-center space-x-2">
            @foreach ($articles['links'] as $link)
                @if ($link['url'])
                    <a href="{{ $link['url'] }}" class="px-3 py-1 rounded {{ $link['active'] ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {!! $link['label'] !!}
                    </a>
                @endif
            @endforeach
          </div>
        </div>

        <!-- 頁尾 -->
        <p class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl text-gray-500 p-4 sm:p-8 text-center">
          無聊玩玩 有問題來信告知 <a href="mailto:qcworkman@gmail.com" class="underline text-blue-600">qcworkman@gmail.com</a><br/>
          copyright © chiuko All rights reserved.
        </p>

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

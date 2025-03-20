<div class="flex justify-center flex-wrap gap-2 mt-2">
  <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 border border-blue-600 text-blue-600 text-xs rounded-full hover:bg-blue-50"><i class="fa-brands fa-facebook-f"></i> FB</a>
  <a href="https://social-plugins.line.me/lineit/share?url={{ urlencode(url()->current()) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 border border-green-600 text-green-600 text-xs rounded-full hover:bg-green-50"><i class="fa-brands fa-line"></i> LINE</a>
  <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 border border-cyan-500 text-cyan-500 text-xs rounded-full hover:bg-cyan-50"><i class="fa-brands fa-x-twitter"></i> X</a>
  <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 border border-blue-400 text-blue-400 text-xs rounded-full hover:bg-blue-50"><i class="fa-brands fa-telegram"></i> Telegram</a>
  <button onclick="
      if (navigator.share) {
          navigator.share({
              title: document.title,
              text: '🎯 快來模擬你的中獎機率吧！🎰 威力彩 / 539 / 樂透都支援！',
              url: '{{ url()->current() }}'
          }).catch(console.error);
      } else {
          alert('此瀏覽器不支援直接分享, 請直接複製網址');
      }"
      class="inline-flex items-center gap-1 px-3 py-1 border border-pink-500 text-pink-500 text-xs rounded-full hover:bg-pink-50">
      <i class="fa-brands fa-instagram"></i> Instagram
  </button>
  <button onclick="
      if (navigator.share) {
          navigator.share({
              title: document.title,
              text: '🚀 測試一下你的手氣！來體驗威力彩模擬器 🤑',
              url: '{{ url()->current() }}'
          }).catch(console.error);
      } else {
          alert('此瀏覽器不支援直接分享, 請直接複製網址');
      }"
      class="inline-flex items-center gap-1 px-3 py-1 border border-black text-black text-xs rounded-full hover:bg-gray-100">
      <i class="fa-brands fa-threads"></i> Threads
  </button>
  <button onclick="navigator.clipboard.writeText('{{ url()->current() }}')" class="inline-flex items-center gap-1 px-3 py-1 border border-gray-500 text-gray-700 text-xs rounded-full hover:bg-gray-100"><i class="fa-solid fa-link"></i> 複製網址</button>
</div>
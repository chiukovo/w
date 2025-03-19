<header class="bg-blue-600 shadow flex flex-wrap items-center px-4 py-3 gap-4 sm:gap-6">
    <!-- 遊戲切換 -->
    <div class="relative">
        <label for="gameSelect" class="sr-only">選擇其他遊戲</label>
        <select id="gameSelect" @change="switchGame($event.target.value)" class="bg-blue-700 text-white text-sm px-3 py-2 rounded-lg border border-blue-800 focus:outline-none focus:ring-2 focus:ring-white transition">
            <option value="" disabled selected>選擇其他遊戲</option>
            <option value="威力彩">威力彩</option>
            <option value="大樂透">大樂透</option>
            <option value="今彩539">今彩539</option>
        </select>
    </div>

    <!-- 文章列表按鈕 -->
    <a href="/taiwanlottery/articles" class="bg-white text-blue-600 text-sm px-4 py-2 rounded-lg font-semibold shadow-sm hover:bg-blue-50 transition">
        📚 文章列表
    </a>

    <!-- 滾動公告 -->
    <div class="marquee flex-1 overflow-hidden">
        <p class="text-white whitespace-nowrap animate-marquee text-sm font-light">
            🚨 本站僅提供號碼模擬工具，所有號碼皆為虛擬模擬，請勿沉迷！ | 工具免費使用，嚴禁非法用途 🚫
        </p>
    </div>
</header>

<!-- 加入 marquee 動畫 -->
<style>
  @keyframes marquee {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
  }
  .animate-marquee {
    animation: marquee 15s linear infinite;
  }
</style>
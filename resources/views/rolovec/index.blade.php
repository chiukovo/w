<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>RO 守護永恆的愛 Classic 精煉模擬器｜裝備衝裝率真實模擬工具</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
  <meta name="description" content="RO 守護永恆的愛 Classic 精煉模擬器，真實還原官方裝備衝裝成功率與損壞規則，手機/電腦皆可用。支援統計花費、修理、運氣計算，讓你一秒體驗非洲人、歐洲人手感！" />
  <meta name="keywords" content="RO, 精煉, 守護永恆的愛, classic, 衝裝, 裝備模擬, 精煉模擬, 衝裝模擬, 精煉成功率, 裝備損壞, RO模擬器, 手遊, 遊戲工具, 傳說裝備, 遊戲, Ragnarok, MMO, RAGNAROK M" />
  <meta name="author" content="藍色白色的吉普車" />

  <!-- Open Graph 社群分享 -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="RO 守護永恆的愛 Classic 精煉模擬器" />
  <meta property="og:description" content="最完整RO精煉模擬器！自動計算精煉花費與運氣，讓你無痛練習衝裝，體驗非洲人歐洲人手氣！" />
  <meta property="og:image" content="https://94ichouo.com/img/rolovec/success.png?v=3" />
  <meta property="og:url" content="https://94ichouo.com/rolovec" />

  <!-- 行動裝置/Apple 裝置啟用桌面模式 -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes" />

  <!-- Favicon 建議 -->
  <link rel="icon" href="https://94ichouo.com/img/rolovec/success.png?v=3" type="image/png" />

  <script async src="https://www.googletagmanager.com/gtag/js?id=G-D4DRBBS5S0"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-D4DRBBS5S0');
  </script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2560043137442562" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/vue@3"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- 音效 -->
  <audio id="audio-success" src="/mp4/refine_success.wav" preload="auto" volume="0.25"></audio>
  <audio id="audio-fail" src="/mp4/refine_failed.wav" preload="auto" volume="0.25"></audio>
  <style>
    .fade-enter-active, .fade-leave-active { transition: all 0.25s; }
    .fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(20px); }
    html, body {
      width: 100vw; max-width: 100vw; overflow-x: hidden; background: #f1f5f9;
      touch-action: manipulation;
    }
    .animate-success { animation: shine 0.7s; }
    @keyframes shine {
      0%   { box-shadow: 0 0 0 0 #48ff48; }
      50%  { box-shadow: 0 0 32px 12px #6aff6a; }
      100% { box-shadow: 0 0 0 0 #48ff48; }
    }
    .animate-fail { animation: shake 0.6s; }
    @keyframes shake {
      0% { transform: translateX(0); }
      20% { transform: translateX(-12px); }
      40% { transform: translateX(12px); }
      60% { transform: translateX(-8px); }
      80% { transform: translateX(8px); }
      100% { transform: translateX(0); }
    }
    .broken-effect {
      background: linear-gradient(135deg, #f87171 70%, #fff 100%);
      border-color: #ef4444 !important;
    }
    .celebrate { animation: celebrate 1.5s 4 alternate; }
    @keyframes celebrate {
      0% { filter: drop-shadow(0 0 0 #fde68a); }
      50% { filter: drop-shadow(0 0 24px #f472b6) drop-shadow(0 0 56px #60a5fa);}
      100% { filter: drop-shadow(0 0 0 #fde68a); }
    }
    .big-btn {
      font-size: 1.35rem;
      min-height: 3.3rem;
      letter-spacing: .05em;
    }
    .pink-glow {
      color: #ec4899; /* tailwind pink-600 */
      text-shadow:
        0 0 12px #fff,     /* 柔白光暈 */
        0 0 18px #f9a8d4,  /* 粉紅外暈1 */
        0 0 32px #f472b6,  /* 粉紅外暈2 */
        0 0 52px #ec4899,  /* 粹紅主暈3 */
        0 0 92px #f472b6,  /* 擴散一層 */
        0 0 8px #fff;      /* 提亮中央 */
      animation: pink-pulse 1.2s infinite alternate;
    }
    @keyframes pink-pulse {
      0% {
        text-shadow:
          0 0 12px #fff,
          0 0 18px #f9a8d4,
          0 0 32px #f472b6,
          0 0 52px #ec4899,
          0 0 92px #f472b6,
          0 0 8px #fff;
      }
      100% {
        text-shadow:
          0 0 24px #fff,
          0 0 36px #f9a8d4,
          0 0 72px #f472b6,
          0 0 96px #ec4899,
          0 0 162px #f472b6,
          0 0 24px #fff;
      }
    }
    [v-cloak] { display: none; }
    .animate-fadein { animation: fadein 0.2s; }
    @keyframes fadein { from { opacity: 0; transform: scale(0.95);} to { opacity: 1; transform: scale(1);} }
    @media (max-width: 480px) {
      .big-btn {
        font-size: 1rem;
        min-height: 2.5rem;
        padding: 0.3rem 0.2rem;
      }
      .big-btn span {
        font-size: 1.1rem;
      }
      .big-btn .text-xs {
        font-size: 0.8rem;
      }
    }
    @media (min-width: 640px) {
      .big-btn {
      }
    }
    .fade-enter-active, .fade-leave-active { transition: all 0.25s; }
    .fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(20px); }
    /* 美化滾動條 */
    .scrollbar-thin { scrollbar-width: thin; }
    .scrollbar-thumb-blue-200::-webkit-scrollbar { width: 6px; }
    .scrollbar-thumb-blue-200::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 6px; }
    .scrollbar-track-blue-50::-webkit-scrollbar-track { background: #eff6ff; }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-1 sm:p-2">
  <div id="app" v-cloak class="w-full flex items-center justify-center">
    <div class="m4 bg-white rounded-2xl shadow-xl px-2 py-3 sm:p-7 w-full max-w-xs sm:max-w-md mx-auto select-none">    
      <!-- 主要重點區塊（精煉等級移到圖片右側，RWD優化） -->
      <div class="flex items-center justify-center mb-2">
        <div id="imgBox"
          class="relative mb-3 w-32 h-32 sm:w-40 sm:h-40 flex items-center justify-center rounded-2xl border-4 border-blue-400 shadow bg-white transition-all duration-300"
          :class="[broken ? 'broken-effect' : '', animateClass, isMax ? 'celebrate' : '']"
          @animationend="animateClass=''"
        >
          <img :src="imgSrc" alt="裝備圖" class="w-28 h-28 sm:w-36 sm:h-36 object-contain pointer-events-none select-none transition-all duration-150">
        </div>
        <div class="flex flex-col items-center justify-center ml-3 sm:ml-6">
          <div class="text-lg sm:text-xl font-bold text-gray-600 mb-1">精煉等級</div>
          <div
            class="text-4xl sm:text-5xl font-extrabold tracking-wider drop-shadow"
            :class="[refineLevel >= 10 ? 'pink-glow' : 'text-pink-600']"
          >
            +@{{ refineLevel }}
          </div>
          <div class="text-xs text-gray-400 mt-1">成功率：<span class="font-bold text-green-600">@{{ isMax ? '---' : `${successRate}%` }}</span></div>
        </div>
      </div>

      <!-- 暱稱顯示區塊 -->
      <div class="flex items-center justify-center mb-1">
        <span class="text-base font-bold text-blue-700 cursor-pointer select-none" @click="showNicknameModal = true">
          暱稱：<span v-if="nickname">@{{ nickname }}</span><span v-else class="text-gray-400 underline">未輸入</span>
        </span>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-1">
        <div class="flex flex-col items-center justify-center w-full">
        <div class="text-lg sm:text-xl font-bold text-gray-600">總花費</div>
        <div class="text-3xl sm:text-4xl font-extrabold text-yellow-500 tracking-wider drop-shadow">@{{ totalCost.toLocaleString() }}</div>
        <div class="text-xs text-gray-400">(Zeny)</div>
        </div>
      </div>
      <div id="msg" class="text-center mt-1 h-7 sm:text-lg text-base font-semibold min-h-[2.2rem]" :class="msgClass">@{{ msg }}</div>  
      <!-- 按鈕 -->
      <div class="flex flex-row gap-3 mb-2 w-full">
        <button @click="doRefine"
          class="big-btn bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-xl transition shadow flex-1"
          :disabled="broken || isMax"
          :class="(broken || isMax) ? 'opacity-60 cursor-not-allowed' : ''"
        >精煉</button>
        <button @click="doRepair" v-show="broken"
          class="big-btn bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-xl transition shadow flex-1"
        >修理</button>
      </div>

      <!-- 精煉下方功能按鈕區塊（水平排列，每個按鈕flex-1） -->
      <div class="flex flex-row gap-2 mb-4 w-full">
        <button @click="toggleSound"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-300 text-gray-500 font-bold rounded-xl transition shadow px-1 py-2 flex-1"
        >
          <span class="text-lg">@{{ soundEnabled ? '🔊' : '🔇' }}</span>
          <span class="text-xs mt-1">音效</span>
        </button>
        <button @click="doReset"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-300 text-gray-500 font-bold rounded-xl transition shadow px-1 py-2 flex-1"
        >
          <span class="text-lg">♻️</span>
          <span class="text-xs mt-1">重製</span>
        </button>
        <button @click="showStats = true"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-blue-300 text-blue-500 font-bold rounded-xl transition shadow px-1 py-2 flex-1"
        >
          <span class="text-lg">📊</span>
          <span class="text-xs mt-1">統計</span>
        </button>
        <button @click="showSetting = true"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-300 text-gray-500 font-bold rounded-xl transition shadow px-1 py-2 flex-1"
        >
          <span class="text-lg">ℹ️</span>
          <span class="text-xs mt-1">關於</span>
        </button>
      </div>

      <!-- 設置彈窗 -->
      <div v-if="showSetting" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs sm:max-w-md relative animate-fadein">
          <button @click="showSetting = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
          <p class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl text-gray-500 p-4 sm:p-8 text-center" style="font-size: 11px;">
            有任何問題 請聯繫 <a href="mailto:qcworkman@gmail.com" class="underline text-blue-600">qcworkman@gmail.com</a><br> copyright © 藍色白色的吉普車 All rights reserved.
          </p>
        </div>
      </div>
      <!-- 自動精煉區塊：自動與排行榜同一行 -->
      <div class="flex items-center justify-center gap-2 mb-4 mt-2 w-full">
        <button @click="toggleAutoRefine" v-if="!isMax"
          class="big-btn bg-pink-400 hover:bg-pink-500 text-white font-bold rounded-xl transition shadow px-4"
          :disabled="isMax"
          :class="isMax ? 'opacity-60 cursor-not-allowed' : ''"
          style="min-width: 110px;"
        >@{{ autoRefineActive ? '停止' : '自動' }}</button>
        <button @click="showRankModal = true; fetchRankings();"
          class="big-btn flex flex-row items-center justify-center bg-yellow-200 hover:bg-yellow-300 text-yellow-700 font-bold rounded-xl transition shadow px-4 relative"
          style="min-width: 110px;">
          <span class="text-lg mr-1">🏆</span>
          排行榜
          <!-- 紅點動畫已移除 -->
        </button>
      </div>
      <!-- 排行按鈕區塊（含icon） -->
      <!-- 已移除歐皇/臉黑排行按鈕，改為單一排行榜按鈕於自動右方 -->

      <!-- 暱稱輸入彈窗 -->
      <div v-if="showNicknameModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs sm:max-w-md relative animate-fadein">
          <button @click="showNicknameModal = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
          <h3 class="text-lg font-bold text-center mb-3 text-blue-600">請輸入暱稱</h3>
          <input v-model="nicknameInput" maxlength="10" placeholder="請輸入暱稱" class="rounded border border-blue-300 px-3 py-2 text-base focus:ring focus:border-blue-500 outline-none w-full text-center font-bold mb-3" />
          <div class="flex justify-center">
            <button @click="saveNickname" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow transition text-base">儲存</button>
          </div>
        </div>
      </div>

      <!-- 統計彈窗（新增詳細資訊） -->
      <div v-if="showStats" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs sm:max-w-md relative animate-fadein">
          <button @click="showStats = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
          <h3 class="text-lg font-bold text-center mb-3 text-blue-600">精煉統計</h3>
          <div class="mb-4">
            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600">成功率</span>
              <span class="font-bold text-green-600">@{{ isMax ? '---' : `${successRate}%` }}</span>
            </div>
            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600">材料消耗</span>
              <span class="font-bold text-pink-700">@{{ isMax ? '---' : materialCost.toLocaleString() }}</span>
            </div>
            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600">修理費</span>
              <span class="font-bold text-blue-600">@{{ repairCost.toLocaleString() }}</span>
            </div>
            <div class="flex justify-between items-center mb-1">
              <span class="text-gray-600">精煉次數</span>
              <span class="font-bold text-gray-700">@{{ totalRefine }}</span>
            </div>
            <div v-if="repairCount3 > 0 || repairCount4 > 0" class="text-pink-600 font-bold animate-bounce mt-2 text-center">
              <span v-if="repairCount3 > 0">🔨 +3 紅槌：@{{ repairCount3 }} 把　</span><br>
              <span v-if="repairCount4 > 0">🔨 +4 紅槌：@{{ repairCount4 }} 把　</span>
            </div>
          </div>
          <h4 class="text-base font-bold text-blue-600 mb-2 text-center">各等級精煉統計</h4>
          <table class="w-full text-sm mb-2">
            <thead>
              <tr class="border-b">
                <th class="py-1 text-left">等級</th>
                <th class="py-1 text-right">嘗試</th>
                <th class="py-1 text-right">成功率</th>
                <th class="py-1 text-right">理論率</th>
                <th class="py-1 text-right">損壞</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, idx) in statsRows" :key="row.level" :class="idx % 2 === 1 ? 'bg-gray-50' : ''">
                <td class="py-1">+@{{ row.level }}</td>
                <td class="py-1 text-right">@{{ row.count }}</td>
                <td class="py-1 text-right">@{{ row.rate }}</td>
                <td class="py-1 text-right">@{{ row.theory }}</td>
                <td class="py-1 text-right">@{{ row.broken }}</td>
              </tr>
            </tbody>
          </table>
          <div class="text-xs text-gray-400 text-center mb-2">* 成功率=實際衝過次數/嘗試次數，理論率為數學期望</div>
          <div class="text-sm text-gray-600 text-center mt-2">修理總次數：<span class="font-bold text-blue-600">@{{ totalRepair }}</span></div>
        </div>
      </div>

      <!-- 排行榜彈窗 -->
      <div v-if="showRankModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs sm:max-w-md relative animate-fadein">
          <button @click="showRankModal = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
          <h3 class="text-lg font-bold text-center mb-3 text-blue-600">排行榜</h3>
          <div class="flex justify-center gap-2 mb-3">
            <button @click="rankType = 'ou'" :class="rankType === 'ou' ? 'bg-yellow-300 text-yellow-800' : 'bg-gray-100 text-gray-500'" class="px-4 py-1 rounded-xl font-bold">歐皇排行</button>
            <button @click="rankType = 'hei'" :class="rankType === 'hei' ? 'bg-gray-400 text-white' : 'bg-gray-100 text-gray-500'" class="px-4 py-1 rounded-xl font-bold">臉黑排行</button>
          </div>
          <div v-if="rankLoading" class="text-center text-gray-400 py-4">載入中...</div>
          <div v-else-if="rankError" class="text-center text-red-500 py-4">@{{ rankError }}</div>
          <div v-else>
            <table class="w-full text-sm mb-2">
              <thead>
                <tr class="border-b">
                  <th class="py-1 text-left">名次</th>
                  <th class="py-1 text-left">暱稱</th>
                  <th class="py-1 text-right">精煉次數</th>
                  <th class="py-1 text-right">總花費</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, idx) in (rankType === 'ou' ? ouRank : heiRank)" :key="row.id || idx" :class="idx % 2 === 1 ? 'bg-gray-50' : ''">
                  <td class="py-1">@{{ idx + 1 }}</td>
                  <td class="py-1">@{{ row.nickname }}</td>
                  <td class="py-1 text-right">@{{ row.refine_count }}</td>
                  <td class="py-1 text-right">@{{ formatCost(row.total_cost) }}</td>
                </tr>
              </tbody>
            </table>
            <div class="text-xs text-gray-400 text-center">* 歐皇排行：精煉次數最少<br>* 臉黑排行：精煉次數最多</div>
          </div>
        </div>
      </div>
      <!-- END 排行榜彈窗 -->

      <!-- 聊天視窗風格留言板（全部預設收合，icon美化） -->
      <div class="fixed bottom-6 left-1/2 z-40 -translate-x-1/2 w-full max-w-xs sm:max-w-md select-none">
        <div class="relative">
          <div @click="commentPanelOpen = !commentPanelOpen" class="flex items-center cursor-pointer bg-gradient-to-r from-gray-100 via-blue-50 to-gray-100 rounded-xl px-4 py-2 shadow-lg border border-blue-200 hover:from-blue-100 hover:to-blue-100 transition relative">            <span class="text-blue-700 font-bold text-base flex-1 flex items-center gap-2">
              <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 0 1-4.39-1.01L3 21l1.01-3.61A7.96 7.96 0 0 1 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z"/></svg>
              留言板
              <span v-if="commentTotal > 0" class="ml-1 text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">@{{ commentTotal }}</span>
              <span v-if="commentHasNew" class="ml-1 w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
            </span>
            <span class="text-blue-400 text-xl transition-transform" :class="commentPanelOpen ? 'rotate-180' : ''">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
            </span>
          </div>
          <transition name="fade">            <div v-if="commentPanelOpen" class="bg-white rounded-xl px-4 py-3 shadow-xl border-blue-200 border mt-2">              <div ref="commentScrollContainer" @scroll="onCommentScroll" class="max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-200 scrollbar-track-blue-50 pr-1">
                <div v-if="comments.length === 0" class="text-gray-400 text-center py-2">目前沒有留言，快來分享你的精煉心得！</div>
                <div v-else class="flex flex-col gap-2 mb-2">
                  <div v-for="(c, idx) in comments" :key="c.id || idx" class="rounded-lg border border-blue-100 bg-white px-3 py-2 shadow-sm" style="flex-direction: column-reverse;">
                    <div class="flex items-center gap-2 mb-1">
                      <span class="font-bold text-blue-700 text-sm">@{{ c.name || '匿名' }}</span>
                      <span class="text-xs text-gray-400">@{{ c.time }}</span>
                    </div>
                    <div class="text-gray-700 whitespace-pre-line text-base">@{{ c.text }}</div>
                  </div>
                </div>
                <!-- 加載更多的loading狀態 -->
                <div v-if="commentLoadingMore" class="text-center py-2">
                  <span class="text-xs text-gray-400">正在加載更多...</span>
                </div>
              </div>
              <div class="flex justify-center mt-2">
                <button @click="showCommentModal = true" class="bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow transition px-4 py-1 text-sm flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m0 0l-6-6m6 6l6-6"/></svg>
                  我要留言
                </button>
              </div>
            </div>
          </transition>
        </div>
      </div>
      <!-- 留言彈窗 -->
      <div v-if="showCommentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs sm:max-w-md relative animate-fadein">
          <button @click="showCommentModal = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
          <h3 class="text-lg font-bold text-center mb-3 text-blue-600">我要留言</h3>
          <form @submit.prevent="addComment" class="flex flex-col gap-2 mb-2">
            <input v-model="commentName" type="text" maxlength="20" required placeholder="暱稱 (必填)" class="rounded border border-blue-300 px-2 py-1 text-base focus:ring focus:border-blue-500 outline-none" />
            <textarea v-model="commentText" rows="2" maxlength="200" required placeholder="留言內容 (限200字)" class="rounded border border-pink-300 px-2 py-1 text-base focus:ring focus:border-pink-500 outline-none resize-none"></textarea>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow transition px-4 py-2 mt-1">送出留言</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    const { createApp, ref, computed, watch, onMounted } = Vue
    createApp({
      setup() {
        const refineLevel = ref(0)
        // 限制自訂精煉等級不可超過14，且只在手動輸入時生效，不影響精煉流程
        function onCustomRefineChange(e) {
          let val = Number(e.target.value)
          if (val > 14) refineLevel.value = 14
          if (val < 0) refineLevel.value = 0
        }
        const broken = ref(false)
        const isMax = computed(() => refineLevel.value >= 15)
        const imgSrc = ref('/img/rolovec/success.png?v=3')
        // 修理費固定 200 萬
        const repairCost = ref(2000000) // 預設200萬
        const totalCost = ref(0)
        const totalMaterial = ref(0)
        const totalRefine = ref(0)
        const msg = ref('手感來了再去遊戲點裝')
        const animateClass = ref('')
        const msgClass = computed(() => {
          if (isMax.value) return 'text-pink-500 text-xl font-bold animate-pulse'
          if (msg.value.includes('成功')) return 'text-green-600'
          if (msg.value.includes('損壞')) return 'text-red-600'
          if (msg.value.includes('掉一階')) return 'text-yellow-600'
          return ''
        })

        // 統計彈窗
        const showStats = ref(false)
        // 各等級嘗試次數、成功次數、損壞次數
        const refineTry = ref(Array(16).fill(0)) // 0~15
        const refinePass = ref(Array(16).fill(0))
        const refineBroken = ref(Array(16).fill(0))

        const lastTitle = ref("RO守愛 Classic 精煉模擬器")
        const funnyTitle = computed(() => {
          let title = "RO守愛 Classic 精煉模擬器"
          if (isMax.value) title = "全服見證，+15王者誕生！"
          else if (refineLevel.value <= 3 && totalRefine.value >= 30) title = "雜質認證"
          else if (refineLevel.value <= 4 && totalRefine.value >= 20) title = "紅槌哥(姊) 您好"
          else if (refineLevel.value >= 13 && totalRefine.value <= 22) title = "GM親友你承認吧"
          else if (refineLevel.value >= 11 && totalRefine.value <= 17) title = "精煉之神就是你"
          else if (refineLevel.value >= 10 && totalRefine.value <= 20) title = "今晚吃雞！"
          else if (refineLevel.value >= 10 && totalRefine.value <= 30) title = "這運氣有點歐喔！"
          else if (totalRefine.value > 50 && refineLevel.value < 8) title = "乖乖安精吧孩子"
          else if (totalRefine.value > 40 && refineLevel.value < 10) title = "非洲人確認"
          else if (refineLevel.value >= 11 && totalRefine.value > 30) title = "手會痠嗎?"
          else if (refineLevel.value >= 7 && totalRefine.value >= 20) title = "進入了苦戰..."
          else if (refineLevel.value < 5 && totalRefine.value >= 30) title = "天黑黑 臉也黑"

          // 只有當新標語不是預設時才更新 lastTitle
          if (title !== "RO守愛 Classic 精煉模擬器") {
            lastTitle.value = title
            return title
          }
          // 預設時回傳上一個特殊狀態（讓標語不會一秒就變回預設）
          return lastTitle.value
        })

        // 標題特效
        const titleClass = computed(() => {
          if (isMax.value) return 'text-pink-500 animate-pulse'
          if (refineLevel.value <= 3 && totalRefine.value >= 30) return 'text-gray-800 animate-pulse'
          if (refineLevel.value >= 13 && totalRefine.value <= 22) return 'text-yellow-500 animate-bounce'
          if (refineLevel.value >= 10 && totalRefine.value <= 30) return 'text-blue-500 animate-bounce'
          if (refineLevel.value >= 11 && totalRefine.value > 30) return 'text-orange-600'
          if (totalRefine.value > 50 && refineLevel.value < 8) return 'text-red-600 animate-pulse'
          if (totalRefine.value > 40 && refineLevel.value < 10) return 'text-red-400 animate-pulse'
          return 'text-blue-700'
        });

        function getSuccessRate(nextRefine) {
          if (nextRefine <= 4) return 100
          if (nextRefine === 5 || nextRefine === 6) return 50
          return 40
        }
        function getMaterialCost(level) {
          return level >= 10 ? 100000 : 20000
        }
        const successRate = computed(() => isMax.value ? 0 : getSuccessRate(refineLevel.value + 1))
        const zenyCost = computed(() => isMax.value ? 0 : (refineLevel.value + 1) * 10000)
        const materialCost = computed(() => isMax.value ? 0 : getMaterialCost(refineLevel.value))

        // 衝過機率（實際）
        const passRateText = computed(() => {
          if (totalRefine.value === 0) return '--';
          return (refineLevel.value / totalRefine.value * 100).toFixed(1) + '%';
        });

        // 理論機率（數學累乘）
        function getTheoryProb(level) {
          let prob = 1;
          for (let i = 1; i <= level; i++) {
            if (i <= 4) prob *= 1;
            else if (i === 5 || i === 6) prob *= 0.5;
            else prob *= 0.4;
          }
          return prob;
        }
        const theoRateText = computed(() => {
          if (refineLevel.value === 0) return '--';
          return (getTheoryProb(refineLevel.value) * 100).toFixed(3) + '%';
        });

        const repairCount3 = ref(0)
        const repairCount4 = ref(0)

        // 是否自動精煉中
        let isAutoRefineStep = false;
        const soundEnabled = ref(true)
        function toggleSound() {
          soundEnabled.value = !soundEnabled.value
        }
        // 音效預設音量
        function setAudioVolume() {
          const audioSuccess = document.getElementById('audio-success')
          const audioFail = document.getElementById('audio-fail')
          if (audioSuccess) audioSuccess.volume = 0.25
          if (audioFail) audioFail.volume = 0.25
        }
        setTimeout(setAudioVolume, 0)

        // 暱稱功能
        const nickname = ref(localStorage.getItem('nickname') || '')
        const nicknameInput = ref(nickname.value)
        const showNicknameModal = ref(false)
        function saveNickname() {
          if (!nicknameInput.value.trim()) return
          nickname.value = nicknameInput.value.trim()
          localStorage.setItem('nickname', nickname.value)
          showNicknameModal.value = false
        }
        // 改寫 doRefine，呼叫後端API，遇到「請先初始化」自動補init再重試
        async function doRefine() {
          if (!nickname.value) {
            showNicknameModal.value = true
            return
          }
          // 呼叫API
          let res = await fetch('/api/refine/do', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nickname: nickname.value })
          })
          let data = await res.json()
          // 若需初始化則自動補init再重試一次
          if (!res.ok && data.message === '請先初始化') {
            const initRes = await fetch('/api/refine/init', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ nickname: nickname.value })
            })
            const initData = await initRes.json()
            if (!initRes.ok) {
              msg.value = initData.message || '初始化失敗';
              return
            }
            // 再次嘗試精煉
            res = await fetch('/api/refine/do', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ nickname: nickname.value })
            })
            data = await res.json()
          }
          if (!res.ok) {
            msg.value = data.message || '精煉失敗';
            return
          }
          refineLevel.value = data.refineLevel
          totalCost.value = data.totalCost
          totalRefine.value = data.totalRefine
          broken.value = data.broken
          msg.value = data.msg
          animateClass.value = data.success ? 'animate-success' : 'animate-fail'
          imgSrc.value = data.success ? '/img/rolovec/success.png?v=3' : '/img/rolovec/error.png?v=2'
          // +15特效
          if (data.isMax) {
            setTimeout(() => {
              msg.value = '🎉 恭喜你成功達到 +15！🎉'
              animateClass.value = ''
            }, 600)
          }
          // 音效
          if (!isAutoRefineStep && soundEnabled.value) {
            if (data.success) {
              const audioSuccess = document.getElementById('audio-success')
              if (audioSuccess) {
                audioSuccess.currentTime = 0;
                audioSuccess.play();
              }
            } else {
              const audioFail = document.getElementById('audio-fail')
              if (audioFail) {
                audioFail.currentTime = 0;
                audioFail.play();
              }
            }
          }
          // 寫入後端回傳的精煉統計
          if (data.stats) {
            for (let i = 0; i < 16; i++) {
              refineTry.value[i] = data.stats.try[i] || 0
              refinePass.value[i] = data.stats.pass[i] || 0
              refineBroken.value[i] = data.stats.broken[i] || 0
            }
          }
        }
        async function doRepair() {
          if (!broken.value) return
          if (!nickname.value) {
            showNicknameModal.value = true
            return
          }
          // 呼叫後端修理API，直接用預設 200 萬
          const res = await fetch('/api/refine/repair', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nickname: nickname.value })
          })
          const data = await res.json()
          if (!res.ok) {
            msg.value = data.message || '修理失敗'
            return
          }
          // 以後端回傳狀態為主
          refineLevel.value = data.refineLevel ?? 0
          broken.value = data.broken ?? false
          totalCost.value = data.totalCost ?? 0
          totalRefine.value = data.totalRefine ?? 0
          msg.value = data.msg || '裝備已修理，可再次精煉！'
          imgSrc.value = '/img/rolovec/success.png?v=3'
          animateClass.value = ''
          if (soundEnabled.value) {
            const audioSuccess = document.getElementById('audio-success')
            if (audioSuccess) {
              audioSuccess.currentTime = 0;
              audioSuccess.play();
            }
          }
        }
        async function doReset() {
          if (!nickname.value) {
            showNicknameModal.value = true
            return
          }
          // 呼叫後端初始化API
          const res = await fetch('/api/refine/init', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nickname: nickname.value })
          })
          const data = await res.json()
          if (!res.ok) {
            msg.value = data.message || '重製失敗';
            return
          }
          // 重設前端狀態（以後端回傳為主）
          refineLevel.value = data.refineLevel ?? 0
          broken.value = data.broken ?? false
          totalCost.value = data.totalCost ?? 0
          totalRefine.value = data.totalRefine ?? 0
          imgSrc.value = '/img/rolovec/success.png?v=3'
          repairCost.value = 2000000
          totalMaterial.value = 0
          msg.value = '手感來了再去遊戲點裝'
          animateClass.value = ''
          repairCount3.value = 0
          repairCount4.value = 0
          autoRefineActive.value = false
          // 統計歸零
          for (let i = 0; i < 16; i++) {
            refineTry.value[i] = 0
            refinePass.value[i] = 0
            refineBroken.value[i] = 0
          }
        }
        // 自動精煉控制
        let autoRefineTimer = null
        const autoRefineActive = ref(false)
        const autoRefineInterval = ref(180)
        const MIN_AUTO_REFINE_INTERVAL = 200 // ms
        watch(autoRefineInterval, (val) => {
          if (val < MIN_AUTO_REFINE_INTERVAL) autoRefineInterval.value = MIN_AUTO_REFINE_INTERVAL
        })
        // 自動精煉效能最佳化：async/await，確保每次都等 API 回來再排下一輪
        async function autoRefineStep() {
          if (!autoRefineActive.value) return
          if (broken.value) {
            await doRepair()
            if (!autoRefineActive.value) return
            if (!isMax.value) {
              autoRefineTimer = setTimeout(() => { autoRefineStep() }, autoRefineInterval.value)
            }
            return
          }
          if (isMax.value) {
            autoRefineActive.value = false
            if (autoRefineTimer) { clearTimeout(autoRefineTimer); autoRefineTimer = null }
            return
          }
          isAutoRefineStep = true;
          await doRefine()
          isAutoRefineStep = false;
          if (!autoRefineActive.value) return
          if (!isMax.value) {
            autoRefineTimer = setTimeout(() => { autoRefineStep() }, autoRefineInterval.value)
          }
        }
        function toggleAutoRefine() {
          if (autoRefineActive.value) {
            autoRefineActive.value = false
            if (autoRefineTimer) { clearTimeout(autoRefineTimer); autoRefineTimer = null }
          } else {
            if (isMax.value) return
            if (autoRefineInterval.value < MIN_AUTO_REFINE_INTERVAL) autoRefineInterval.value = MIN_AUTO_REFINE_INTERVAL
            autoRefineActive.value = true
            autoRefineStep()
          }
        }
        // 統計表資料
        // 統計表資料（含理論率、損壞次數）
        const statsRows = computed(() => {
          const arr = []
          for (let i = 5; i <= 15; i++) {
            const count = refineTry.value[i]
            const pass = refinePass.value[i]
            // 理論率
            let theory = '--'
            if (i <= 6) theory = i === 5 || i === 6 ? '50%' : '100%'
            else theory = '40%'
            // 損壞次數
            const broken = refineBroken.value[i] || 0
            arr.push({
              level: i,
              count: count,
              rate: count > 0 ? ((pass / count * 100).toFixed(1) + '%') : '--',
              theory: theory,
              broken: broken
            })
          }
          return arr
        })

        // 修理總次數（+5~+15損壞次數總和）
        const totalRepair = computed(() => {
          let sum = 0
          for (let i = 5; i <= 15; i++) {
            sum += refineBroken.value[i] || 0
          }
          return sum
        })

        const showSetting = ref(false)
        function applySetting() {
          showSetting.value = false
        }
        // 留言板功能
        const commentPanelOpen = ref(false)
        const comments = ref([])
        const commentName = ref(localStorage.getItem('commentName') || '')
        const commentText = ref('')
        const showCommentModal = ref(false)
        const commentLoading = ref(false)
        const commentError = ref('')
        const commentHasNew = ref(false)
        const commentTotal = ref(0)
        const commentCurrentPage = ref(1)
        const commentHasMore = ref(true)
        const commentScrollContainer = ref(null)
        const commentLoadingMore = ref(false)
        let lastCommentCount = 0
        let lastCommentId = null        // API: 取得留言列表
        async function fetchComments(isAuto = false, loadMore = false) {
          // 防止重複加載
          if (loadMore && commentLoadingMore.value) return
          
          if (loadMore) {
            commentLoadingMore.value = true
          } else if (!isAuto) {
            commentLoading.value = true
          }
          commentError.value = ''
          try {
            const page = loadMore ? commentCurrentPage.value + 1 : 1
            // 自動更新只拉第一頁
            const url = isAuto ? '/api/comments?page=1' : `/api/comments?page=${page}`
            const res = await fetch(url)
            if (!res.ok) throw new Error('留言載入失敗')
            const data = await res.json()
            
            const newComments = (data.data || []).map(c => ({
              id: c.id,
              name: c.name,
              text: c.content,
              time: c.created_at ? new Date(c.created_at).toLocaleString('zh-TW', { hour12: false }) : ''
            }))
              if (loadMore) {
              // 如果返回的資料為空，表示沒有更多資料了
              if (newComments.length === 0) {
                commentHasMore.value = false
              } else {
                // 加載更多時追加到現有留言
                comments.value = [...comments.value, ...newComments]
                commentCurrentPage.value = page
              }
            } else if (isAuto) {
              // 自動更新時只更新第一頁
              if (comments.value.length > 0) {
                // 保留除第一頁外的留言，只更新第一頁內容
                const firstPageSize = 5
                const restComments = comments.value.slice(firstPageSize)
                comments.value = [...newComments, ...restComments]
              } else {
                comments.value = newComments
              }
            } else {
              // 首次加載或刷新時替換所有留言
              comments.value = newComments
              commentCurrentPage.value = 1
            }
            
            commentTotal.value = data.total || 0
            // 只有在非loadMore或返回有資料時才更新has_more狀態
            if (!loadMore || newComments.length > 0) {
              commentHasMore.value = data.has_more || false
            }
            
            // 紅點判斷：自動輪詢時只比對，不覆蓋 lastCommentId
            if (isAuto && !commentPanelOpen.value) {
              if (lastCommentId !== null && newComments.length > 0 && newComments[0].id !== lastCommentId) {
                commentHasNew.value = true
              }
            }
            // 非自動輪詢（首次載入或展開）才覆蓋 lastCommentId
            if (!isAuto && !loadMore && newComments.length > 0) {
              lastCommentId = newComments[0].id
            }
          } catch (e) {
            if (!isAuto) commentError.value = e.message || '留言載入失敗'
          } finally {
            if (loadMore) {
              commentLoadingMore.value = false
            } else if (!isAuto) {
              commentLoading.value = false
            }
          }
        }        // 滾動到底部加載更多
        function onCommentScroll(event) {
          const container = event.target
          const scrollTop = container.scrollTop
          const scrollHeight = container.scrollHeight
          const clientHeight = container.clientHeight
          
          // 滾動到底部前50px時觸發加載，並防止重複加載
          if (scrollTop + clientHeight >= scrollHeight - 50 && 
              commentHasMore.value && 
              !commentLoading.value && 
              !commentLoadingMore.value) {
            fetchComments(false, true)
          }
        }

        // API: 新增留言
        async function addComment() {
          commentError.value = ''
          if (!commentName.value.trim()) {
            commentError.value = '暱稱必填'
            return
          }
          if (!commentText.value.trim()) {
            commentError.value = '留言內容必填'
            return
          }
          if (commentText.value.length > 200) {
            commentError.value = '留言內容限200字內'
            return
          }
          if (commentName.value.length > 20) {
            commentError.value = '暱稱限20字內'
            return
          }
          commentLoading.value = true
          try {
            const res = await fetch('/api/comments', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ name: commentName.value.trim(), content: commentText.value.trim() })
            })
            if (!res.ok) {
              const err = await res.json()
              commentError.value = err.message || '送出失敗'
              return
            }
            // 暱稱記錄 localStorage
            localStorage.setItem('commentName', commentName.value.trim())
            commentText.value = ''
            showCommentModal.value = false
            await fetchComments()
          } catch (e) {
            commentError.value = e.message || '送出失敗'
          } finally {
            commentLoading.value = false
          }
        }

        // 展開留言板時自動載入，並清除紅點，並更新 lastCommentId
        watch(commentPanelOpen, (open) => {
          if (open) {
            fetchComments()
            commentHasNew.value = false // 展開時紅點消失
            // 展開時覆蓋 lastCommentId
            if (comments.value.length > 0) {
              lastCommentId = comments.value[0].id
            }
          }
        })

        // 定時10秒自動檢查新留言
        setInterval(() => {
          fetchComments(true)
        }, 5000)

        // 頁面載入時自動初始化 refine 狀態
        onMounted(async () => {
          if (nickname.value) {
            await doReset()
          }
        })

        // 排行榜彈窗
        const showRankModal = ref(false)
        const rankType = ref('ou') // 'ou' or 'hei'
        const ouRank = ref([])
        const heiRank = ref([])
        const rankLoading = ref(false)
        const rankError = ref('')
        // 取得排行榜API
        async function fetchRankings() {
          rankLoading.value = true
          rankError.value = ''
          try {
            const res = await fetch('/api/refine/rankings')
            if (!res.ok) throw new Error('排行榜載入失敗')
            const data = await res.json()
            ouRank.value = data.ou || []
            heiRank.value = data.hei || []
            // 紅點已移除，不再設定 rankHasNew
          } catch (e) {
            rankError.value = e.message || '排行榜載入失敗'
          } finally {
            rankLoading.value = false
          }
        }
        function showOuRank() {
          rankType.value = 'ou'
          showRankModal.value = true
          fetchRankings()
        }
        function showHeiRank() {
          rankType.value = 'hei'
          showRankModal.value = true
          fetchRankings()
        }

        function formatCost(cost) {
          if (cost >= 1000000) return (cost / 1000000).toFixed(cost % 1000000 === 0 ? 0 : 1) + 'm';
          if (cost >= 1000) return (cost / 1000).toFixed(cost % 1000 === 0 ? 0 : 1) + 'k';
          return cost.toLocaleString();
        }

        return {
          // rankHasNew, fetchRankings 不再回傳 rankHasNew
          refineLevel, broken, isMax, imgSrc, repairCost,
          totalCost, totalMaterial, totalRefine,
          msg, animateClass, msgClass,
          successRate, zenyCost, materialCost,
          repairCount3, repairCount4,
          doRefine, doRepair, doReset,
          toggleAutoRefine,
          autoRefineActive,
          autoRefineInterval,
          funnyTitle, titleClass,
          passRateText, theoRateText,
          showStats, statsRows,
          totalRepair,
          soundEnabled,
          toggleSound,
          showSetting,
          applySetting,
          commentPanelOpen, comments, commentName, commentText, addComment, showCommentModal,
          commentLoading, commentError, commentHasNew, commentTotal, commentCurrentPage, 
          commentHasMore, commentScrollContainer, onCommentScroll, commentLoadingMore,
          nickname, nicknameInput, showNicknameModal, saveNickname,
          showRankModal, rankType, ouRank, heiRank, rankLoading, rankError, showOuRank, showHeiRank,
          fetchRankings,
          formatCost
        }
      }
    }).mount('#app')
  </script>
</body>
</html>

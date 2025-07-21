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
  <meta property="og:image" content="https://94ichouo.com/img/rolovec/success.png" />
  <meta property="og:url" content="https://94ichouo.com/rolovec" />

  <!-- 行動裝置/Apple 裝置啟用桌面模式 -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-title" content="RO 守護永恆的愛 Classic 精煉模擬器" />

  <!-- Favicon 建議 -->
  <link rel="icon" href="https://94ichouo.com/img/rolovec/success.png" type="image/png" />

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
        0 0 52px #ec4899,  /* 粉紅主暈3 */
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
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-1 sm:p-2">
  <div id="app" v-cloak class="w-full flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl px-2 py-3 sm:p-7 w-full max-w-xs sm:max-w-md mx-auto select-none">      
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
        </div>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-1">
        <div class="flex flex-col items-center justify-center w-full">
        <div class="text-lg sm:text-xl font-bold text-gray-600">總花費</div>
        <div class="text-3xl sm:text-4xl font-extrabold text-yellow-500 tracking-wider drop-shadow">@{{ totalCost.toLocaleString() }}</div>
        <div class="text-xs text-gray-400">(Zeny)</div>
        </div>
      </div>
      <div class="mt-1 mb-3 text-center text-sm text-blue-500 font-semibold tracking-wide" v-if="isMax">
        🎉 恭喜你成功達到 +15 🎉
      </div>

      <!-- 按鈕 -->
      <div class="flex gap-3 mb-2">
        <button @click="doRefine"
          class="flex-1 big-btn bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-xl transition shadow"
          :disabled="broken || isMax"
          :class="(broken || isMax) ? 'opacity-60 cursor-not-allowed' : ''"
        >精煉</button>
        <div class="flex flex-col items-center justify-center flex-1" v-show="broken">
          <button @click="doRepair"
            class="w-full big-btn bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-xl transition shadow mb-1"
          >修理</button>
        </div>
      </div>

      <!-- 精煉下方功能按鈕區塊（RWD優化，icon置中，文字縮小/隱藏） -->
      <div class="flex flex-wrap gap-2 mb-4 justify-center items-center">
        <button @click="toggleSound"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-300 text-gray-500 font-bold rounded-xl transition shadow px-2 py-2 w-16 sm:w-24"
          style="min-width: 64px; max-width: 100px;"
        >
          <span class="text-xl">@{{ soundEnabled ? '🔊' : '🔇' }}</span>
          <span class="text-xs sm:text-base mt-1">音效</span>
        </button>
        <button @click="doReset"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-300 text-gray-500 font-bold rounded-xl transition shadow px-2 py-2 w-16 sm:w-24"
          style="min-width: 64px; max-width: 100px;"
        >
          <span class="text-xl">♻️</span>
          <span class="text-xs sm:text-base mt-1">重製</span>
        </button>
        <button @click="showSetting = true"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-300 text-gray-500 font-bold rounded-xl transition shadow px-2 py-2 w-16 sm:w-24"
          style="min-width: 64px; max-width: 100px;"
        >
          <span class="text-xl">⚙️</span>
          <span class="text-xs sm:text-base mt-1">設置</span>
        </button>
        <button @click="showStats = true"
          class="big-btn flex flex-col items-center justify-center bg-gray-100 hover:bg-blue-300 text-blue-500 font-bold rounded-xl transition shadow px-2 py-2 w-16 sm:w-24"
          style="min-width: 64px; max-width: 100px;"
        >
          <span class="text-xl">📊</span>
          <span class="text-xs sm:text-base mt-1">統計</span>
        </button>
      </div>

      <!-- 設置彈窗 -->
      <div v-if="showSetting" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs sm:max-w-md relative animate-fadein">
          <button @click="showSetting = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
          <h3 class="text-lg font-bold text-center mb-3 text-blue-600">設置</h3>
          <div class="mb-4">
            <label for="settingRepairCost" class="text-gray-600 text-sm mb-2 block">自訂修理費：</label>
            <input id="settingRepairCost" type="number" v-model.number="settingRepairCost" min="0" step="1000"
              class="w-full rounded border border-blue-300 px-2 py-1 text-right focus:ring focus:border-blue-500 outline-none text-lg font-bold" />
            <span class="text-gray-500 text-xs">Zeny</span>
          </div>
          <div class="mb-4">
            <label for="settingRefineLevel" class="text-gray-600 text-sm mb-2 block">自訂精煉等級：</label>
            <input id="settingRefineLevel" type="number" v-model.number="settingRefineLevel" min="0" max="14"
              class="w-full rounded border border-pink-300 px-2 py-1 text-center focus:ring focus:border-pink-500 outline-none text-lg font-bold" />
            <span class="text-gray-500 text-xs">+等級（0~14）</span>
          </div>
          <div class="flex justify-center">
            <button @click="applySetting" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow transition text-base">確認</button>
          </div>
        </div>
      </div>
      <!-- 自動精煉區塊：自動與速度同一行 -->
      <div class="flex items-center justify-center gap-2 mb-4 mt-2 w-full">
        <button @click="toggleAutoRefine" v-if="!isMax"
          class="big-btn bg-pink-400 hover:bg-pink-500 text-white font-bold rounded-xl transition shadow px-4"
          :disabled="isMax"
          :class="isMax ? 'opacity-60 cursor-not-allowed' : ''"
          style="min-width: 110px;"
        >@{{ autoRefineActive ? '停止' : '自動' }}</button>
        <label class="ml-2 text-gray-500 text-base whitespace-nowrap">速度：</label>
        <select v-model.number="autoRefineInterval" class="rounded border border-blue-300 px-2 py-1 text-base focus:ring focus:border-blue-500 outline-none w-28">
          <option :value="500">正常</option>
          <option :value="300">快</option>
          <option :value="180">很快</option>
          <option :value="80">超快</option>
        </select>
      </div>
      <div id="msg" class="text-center mt-1 h-7 sm:text-lg text-base font-semibold min-h-[2.2rem]" :class="msgClass">@{{ msg }}</div>

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
      <style>
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
      </style>
      <p class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl text-gray-500 p-4 sm:p-8 text-center" style="font-size: 11px;">
        有任何問題 請聯繫 <a href="mailto:qcworkman@gmail.com" class="underline text-blue-600">qcworkman@gmail.com</a><br> copyright © 藍色白色的吉普車 All rights reserved.
      </p>
    </div>
  </div>

  <script>
    const { createApp, ref, computed, watch } = Vue
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
        const imgSrc = ref('/img/rolovec/success.png')
        const repairCost = ref(2000000) // 預設200萬
        const totalCost = ref(0)
        const totalMaterial = ref(0)
        const totalRefine = ref(0)
        const msg = ref('隨便玩玩 別走心^_^')
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

        function doRefine() {
          if (broken.value || isMax.value) return
          totalRefine.value++
          // 統計：記錄本次嘗試
          if (refineLevel.value >= 4 && refineLevel.value < 15) {
            refineTry.value[refineLevel.value + 1]++
          }
          totalCost.value += zenyCost.value
          totalMaterial.value += materialCost.value
          let rate = successRate.value
          let roll = Math.random()
          if (rate === 100 || roll < rate / 100) {
            // 統計：記錄本次成功
            if (refineLevel.value >= 4 && refineLevel.value < 15) {
              refinePass.value[refineLevel.value + 1]++
            }
            refineLevel.value++
            msg.value = rate === 100 ? '精煉成功！（100%）' : `精煉成功！（${rate}%）`
            imgSrc.value = '/img/rolovec/success.png'
            animateClass.value = 'animate-success'
            // 播放成功音效（非自動精煉時）
            if (!isAutoRefineStep && soundEnabled.value) {
              const audioSuccess = document.getElementById('audio-success')
              if (audioSuccess) {
                audioSuccess.currentTime = 0;
                audioSuccess.play();
              }
            }
            if (refineLevel.value === 15) {
              setTimeout(() => {
                msg.value = '🎉 恭喜你成功達到 +15！🎉'
                animateClass.value = ''
              }, 600)
            }
          } else {
            // 失敗一律掉1級
            refineLevel.value = Math.max(0, refineLevel.value - 1)
            let failLevel = refineLevel.value + 1 // 失敗前的等級
            // +10~+14必壞、+4~+9 50%壞、其餘不壞
            let willBreak = false
            if (failLevel >= 10 && failLevel <= 14) {
              willBreak = true
            } else if (failLevel >= 4 && failLevel <= 9) {
              if (Math.random() < 0.5) willBreak = true
            }
            // 播放失敗音效（非自動精煉時）
            if (!isAutoRefineStep && soundEnabled.value) {
              const audioFail = document.getElementById('audio-fail')
              if (audioFail) {
                audioFail.currentTime = 0;
                audioFail.play();
              }
            }
            if (willBreak) {
              broken.value = true
              if (failLevel === 4) repairCount3.value++
              if (failLevel === 5) repairCount4.value++
              // 統計：損壞次數
              if (failLevel >= 5 && failLevel <= 15) {
                refineBroken.value[failLevel]++
              }
              msg.value = `精煉失敗！裝備損壞！（掉至+${refineLevel.value}）` + ((failLevel === 3 || failLevel === 4) ? `\n哎呀！+${failLevel} 紅槌又來啦！` : '')
              imgSrc.value = '/img/rolovec/error.png?v=1'
              animateClass.value = 'animate-fail'
            } else {
              msg.value = `精煉失敗！掉一階（+${refineLevel.value}）`
              imgSrc.value = '/img/rolovec/error.png?v=1'
              animateClass.value = 'animate-fail'
            }
          }
        }
        function doRepair() {
          if (!broken.value) return
          totalCost.value += repairCost.value
          broken.value = false
          msg.value = '裝備已修理，可再次精煉！'
          imgSrc.value = '/img/rolovec/success.png'
          animateClass.value = ''
          if (soundEnabled.value) {
            const audioSuccess = document.getElementById('audio-success')
            if (audioSuccess) {
              audioSuccess.currentTime = 0;
              audioSuccess.play();
            }
          }
        }
        function doReset() {
          refineLevel.value = 0
          broken.value = false
          imgSrc.value = '/img/rolovec/success.png'
          repairCost.value = 2000000
          totalCost.value = 0
          totalMaterial.value = 0
          totalRefine.value = 0
          msg.value = '歡迎精煉，祝你+15！'
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
        function autoRefineStep() {
          if (broken.value) {
            doRepair()
            // 修理後自動繼續
            setTimeout(() => {
              if (autoRefineActive.value && !isMax.value) autoRefineStep()
            }, autoRefineInterval.value)
            return
          }
          if (isMax.value) {
            autoRefineActive.value = false
            autoRefineTimer && clearTimeout(autoRefineTimer)
            autoRefineTimer = null
            return
          }
          isAutoRefineStep = true;
          doRefine()
          isAutoRefineStep = false;
          autoRefineTimer = setTimeout(() => {
            if (autoRefineActive.value && !isMax.value) autoRefineStep()
          }, autoRefineInterval.value)
        }
        function toggleAutoRefine() {
          if (autoRefineActive.value) {
            autoRefineActive.value = false
            autoRefineTimer && clearTimeout(autoRefineTimer)
            autoRefineTimer = null
          } else {
            if (isMax.value) return
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
        const settingRepairCost = ref(repairCost.value)
        const settingRefineLevel = ref(refineLevel.value)
        function applySetting() {
          repairCost.value = settingRepairCost.value
          refineLevel.value = Math.max(0, Math.min(14, settingRefineLevel.value))
          showSetting.value = false
        }
        watch(showSetting, (val) => {
          if (val) {
            settingRepairCost.value = repairCost.value
            settingRefineLevel.value = refineLevel.value
          }
        })

        return {
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
          settingRepairCost,
          settingRefineLevel,
          applySetting,
        }
      }
    }).mount('#app')
  </script>
</body>
</html>

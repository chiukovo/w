<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>RO 守護永恆的愛 Classic 精煉模擬器｜裝備衝裝率真實模擬工具</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
  <meta name="description" content="RO 守護永恆的愛 Classic 精煉模擬器，真實還原官方裝備衝裝成功率與損壞規則，手機/電腦皆可用。支援統計花費、修理、運氣計算，讓你一秒體驗非洲人、歐洲人手感！" />
  <meta name="keywords" content="RO, 精煉, 守護永恆的愛, classic, 衝裝, 裝備模擬, 精煉模擬, 衝裝模擬, 精煉成功率, 裝備損壞, RO模擬器, 手遊, 遊戲工具, 傳說裝備, 遊戲, Ragnarok, MMO, RAGNAROK M" />
  <meta name="author" content="chiuko" />

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
    html, body { width: 100vw; max-width: 100vw; overflow-x: hidden; background: #f1f5f9; }

    [v-cloak] { display: none; }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-1 sm:p-2">
  <div id="app" v-cloak class="w-full flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl px-2 py-3 sm:p-7 w-full max-w-xs sm:max-w-md mx-auto select-none">
      <h2
        class="text-2xl sm:text-3xl font-extrabold text-center mb-2 transition-all duration-200"
        :class="[
          'tracking-wide leading-snug',
          titleClass
        ]"
      >
        @{{ funnyTitle }}
      </h2>
      
      <!-- 主要重點區塊 -->
      <div class="flex flex-col items-center mb-2">
        <div id="imgBox"
          class="relative mb-3 w-32 h-32 sm:w-40 sm:h-40 flex items-center justify-center rounded-2xl border-4 border-blue-400 shadow bg-white transition-all duration-300"
          :class="[broken ? 'broken-effect' : '', animateClass, isMax ? 'celebrate' : '']"
          @animationend="animateClass=''"
        >
          <img :src="imgSrc" alt="裝備圖" class="w-28 h-28 sm:w-36 sm:h-36 object-contain pointer-events-none select-none transition-all duration-150">
        </div>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-1">
        <div class="flex flex-col items-center justify-center w-full">
          <div class="text-lg sm:text-xl font-bold text-gray-600">精煉等級</div>
          <div class="text-4xl sm:text-5xl font-extrabold text-pink-600 tracking-wider drop-shadow">+@{{ refineLevel }}</div>
        </div>
        <div class="flex flex-col items-center justify-center w-full mt-2 sm:mt-0">
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
        <button @click="doRepair"
          class="flex-1 big-btn bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-xl transition shadow"
          v-show="broken"
        >修理</button>
      </div>
      <div id="msg" class="text-center mt-1 h-7 sm:text-lg text-base font-semibold min-h-[2.2rem]" :class="msgClass">@{{ msg }}</div>

      <!-- 次要統計 -->
      <div class="bg-gray-50 rounded-xl px-4 py-3 mt-2 shadow-inner text-base sm:text-lg">
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
        <div class="flex justify-between items-center">
          <span class="text-gray-600">精煉次數</span>
          <span class="font-bold text-gray-700">@{{ totalRefine }}</span>
        </div>
      </div>

      <!-- 修理費設定 -->
      <div class="flex items-center justify-between gap-2 mt-3 mb-1 px-1 text-base sm:text-lg">
        <label for="repairCostInput" class="text-gray-500">修理費：</label>
        <input id="repairCostInput" type="number" v-model.number="repairCost" min="0" step="1000"
          class="w-28 rounded border border-blue-300 px-2 py-1 text-right focus:ring focus:border-blue-500 outline-none"
          :disabled="isMax"
        >
        <span class="text-gray-500 text-xs">Zeny</span>
      </div>
      <p class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl text-gray-500 p-4 sm:p-8 text-center" style="font-size: 11px;">
        有任何問題 請聯繫 <a href="mailto:qcworkman@gmail.com" class="underline text-blue-600">qcworkman@gmail.com</a><br> copyright © chiuko All rights reserved.
      </p>
    </div>
  </div>

  <script>
    const { createApp, ref, computed } = Vue
    createApp({
      setup() {
        const refineLevel = ref(0)
        const broken = ref(false)
        const isMax = computed(() => refineLevel.value >= 15)
        const imgSrc = ref('/img/rolovec/success.png')
        const repairCost = ref(2000000) // 預設200萬
        const totalCost = ref(0)
        const totalMaterial = ref(0)
        const totalRefine = ref(0)
        const msg = ref('歡迎精煉，祝你+15！')
        const animateClass = ref('')
        const msgClass = computed(() => {
          if (isMax.value) return 'text-pink-500 text-xl font-bold animate-pulse'
          if (msg.value.includes('成功')) return 'text-green-600'
          if (msg.value.includes('損壞')) return 'text-red-600'
          if (msg.value.includes('掉一階')) return 'text-yellow-600'
          return ''
        })
        const lastTitle = ref("RO守愛 Classic 精煉模擬器")
        const funnyTitle = computed(() => {
          let title = "RO守愛 Classic 精煉模擬器"
          if (isMax.value) title = "全服見證，+15王者誕生！"
          else if (refineLevel.value <= 3 && totalRefine.value >= 30) title = "再這樣GM要關心你了！"
          else if (refineLevel.value <= 3 && totalRefine.value >= 20) title = "你是不是忘記開歐洲VPN？"
          else if (refineLevel.value < 2 && totalRefine.value >= 25) title = "別鬧了，GM要來檢查你帳號！"
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

        function doRefine() {
          if (broken.value || isMax.value) return
          totalRefine.value++
          totalCost.value += zenyCost.value
          totalMaterial.value += materialCost.value
          let rate = successRate.value
          let roll = Math.random()
          if (rate === 100 || roll < rate / 100) {
            refineLevel.value++
            msg.value = rate === 100 ? '精煉成功！（100%）' : `精煉成功！（${rate}%）`
            imgSrc.value = '/img/rolovec/success.png'
            animateClass.value = 'animate-success'
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
            if (willBreak) {
              broken.value = true
              msg.value = `精煉失敗！裝備損壞！（掉至+${refineLevel.value}）`
              imgSrc.value = '/img/rolovec/error.png'
              animateClass.value = 'animate-fail'
            } else {
              msg.value = `精煉失敗！掉一階（+${refineLevel.value}）`
              imgSrc.value = '/img/rolovec/error.png'
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
        }
        return {
          refineLevel, broken, isMax, imgSrc, repairCost,
          totalCost, totalMaterial, totalRefine,
          msg, animateClass, msgClass,
          successRate, zenyCost, materialCost,
          doRefine, doRepair,
          funnyTitle, titleClass,
          passRateText, theoRateText
        }
      }
    }).mount('#app')
  </script>
</body>
</html>

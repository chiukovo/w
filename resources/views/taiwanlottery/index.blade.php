<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>彩券下注玩玩看</title>
    <meta name="description" content="彩券頭獎到底有多難中？我們透過數據分析，揭露中獎機率，讓你了解你的中獎機率有多低，科學化下注更理性！">
    <meta name="keywords" content="威力彩, 中獎機率, 威力彩分析, 樂透統計, 頭獎機率, 彩券數據">
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D4DRBBS5S0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', 'G-D4DRBBS5S0');
      </script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* 為每個球創建不同的動畫延遲類 */
        .float-delay-0 {
            opacity: 0;
            animation: float 2s ease-in-out infinite, fadeIn 0.5s ease-out forwards;
        }
        .float-delay-1 {
            opacity: 0;
            animation: float 2s ease-in-out infinite 0.2s, fadeIn 0.5s ease-out 0.2s forwards;
        }
        .float-delay-2 {
            opacity: 0;
            animation: float 2s ease-in-out infinite 0.4s, fadeIn 0.5s ease-out 0.4s forwards;
        }
        .float-delay-3 {
            opacity: 0;
            animation: float 2s ease-in-out infinite 0.6s, fadeIn 0.5s ease-out 0.6s forwards;
        }
        .float-delay-4 {
            opacity: 0;
            animation: float 2s ease-in-out infinite 0.8s, fadeIn 0.5s ease-out 0.8s forwards;
        }
        .float-delay-5 {
            opacity: 0;
            animation: float 2s ease-in-out infinite 1s, fadeIn 0.5s ease-out 1s forwards;
        }
        .float-delay-6 {
            opacity: 0;
            animation: float 2s ease-in-out infinite 1.2s, fadeIn 0.5s ease-out 1.2s forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .matched {
            color: red;
        }
        [v-cloak] {
        display: none;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen p-4 sm:p-6 md:p-8">
    <div id="app" class="max-w-7xl mx-auto" v-cloak>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-800 mb-4 sm:mb-6 md:mb-8 mt-2 sm:mt-4 text-center tracking-tight">
            威力彩下注分析
        </h1>
        <h2 class="text-xl sm:text-2xl font-bold text-slate-700 mb-6 sm:mb-10 text-center">假設開獎號碼</h2>

        <div class="flex justify-center flex-wrap gap-2 sm:gap-3 mb-8 sm:mb-12">
            <span v-for="(num, index) in winningNumbers" 
                  :key="num" 
                  :class="[
                      'flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-full',
                      'bg-gradient-to-br from-amber-400 to-amber-600',
                      'text-white text-lg sm:text-2xl font-bold shadow-xl',
                      'hover:scale-110 transition-all duration-300',
                      `float-delay-${index}`
                  ]">
                @{{ num }}
            </span>
            <span :class="[
                      'flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-full',
                      'bg-gradient-to-br from-rose-500 to-rose-700',
                      'text-white text-lg sm:text-2xl font-bold shadow-xl',
                      'hover:scale-110 transition-all duration-300',
                      'float-delay-6'
                  ]">
                @{{ secondaryNumber }}
            </span>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 md:p-8 mb-6 sm:mb-8">
            <div class="space-y-4">
                <div class="flex flex-col items-center">
                    <label for="betCount" class="text-lg sm:text-xl font-semibold text-gray-700 mb-3 text-center">
                        老闆~我要買 (最大5000張):
                    </label>
                    <input type="tel" 
                           id="betCount" 
                           v-model="betCount" 
                           min="1" 
                           max="5000" 
                           :disabled="isCalculating"
                           class="w-full max-w-[16rem] sm:max-w-xs px-4 py-3 text-lg border border-gray-300 rounded-lg 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  shadow-sm" />
                    <p class="text-base sm:text-lg text-gray-600 mt-3">
                        老闆: @{{ betCount }}張, 收您：<span class="font-semibold text-blue-600">@{{ formatCurrency(betCount * 100) }}</span> 元
                    </p>
                    <p class="text-base sm:text-lg text-gray-600 mt-3">PS: 頭獎中獎機率大約為1億分之4.4<br>大約等同連續2年抽中汽車</p>
                    <p v-if="betCount > 5000" class="text-rose-500 font-medium text-sm sm:text-base">不可超過 5000 張, 太貴了不要亂花!</p>
                </div>

                <div class="flex justify-center mt-6">
                    <button @click="startSimulation" 
                            :disabled="isCalculating || betCount <= 0 || betCount > 10000"
                            class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-4 bg-gradient-to-r from-emerald-500 to-emerald-700 
                                   text-white text-lg sm:text-xl font-bold rounded-full
                                   shadow-lg hover:shadow-2xl transform hover:-translate-y-1 
                                   transition-all duration-300 disabled:opacity-50 
                                   disabled:cursor-not-allowed disabled:transform-none">
                        開始計算
                    </button>
                </div>
            </div>
        </div>

        <div v-if="isCalculating" class="text-2xl sm:text-3xl text-blue-600 text-center mt-6 sm:mt-8 animate-pulse font-bold">
            計算中...
        </div>

        <div id="recordsSection" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-6 sm:mt-8">
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">
                    中獎記錄
                </h3>
                <div class="h-[240px] lg:h-[160px] sm:h-[300px] overflow-y-auto space-y-2 text-sm sm:text-base">
                    <p v-for="result in sortedWinningHistory" 
                       :key="result.id" 
                       class="p-2 sm:p-3 bg-green-50 rounded-lg">
                        <span class="font-medium">第 @{{ result.id }} 注: </span>
                        <span v-for="(num, index) in result.numbers" 
                              :key="index"
                              class="font-semibold"
                        >
                            
                            <span :class="getMatchedClass(num)"> @{{ num }}</span>
                            <span v-if="index < result.numbers.length - 1">, </span>
                        </span>
                        <span class="font-semibold" :class="getSecondaryMatchedClass(result.secondary)">
                            + @{{ result.secondary }}
                        </span>
                        <span class="block sm:inline sm:ml-2 text-emerald-600 font-semibold">
                            @{{ result.prizeName }}: @{{ formatCurrency(result.prize) }} 元
                        </span>
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4">
                    投注紀錄
                </h3>
                <div class="h-[240px] lg:h-[160px] sm:h-[300px] overflow-y-auto space-y-2 text-sm sm:text-base">
                    <p v-for="result in history" 
                       :key="result.id" 
                       class="p-2 sm:p-3 bg-gray-50 rounded-lg"
                       :class="{'text-red-500 font-bold': result.prize === 0}">
                        @{{ result.text }}
                    </p>
                </div>
            </div>
        </div>

        <div v-if="simulationFinished" id="resultsSection" class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl p-4 sm:p-8 mb-10">
            <div class="space-y-4 sm:space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <div class="p-4 sm:p-6 bg-slate-50 rounded-xl">
                        <p class="text-lg sm:text-xl">共買了：<strong class="text-xl sm:text-2xl">@{{ totalBets }}</strong> 張</p>
                        <p class="text-base sm:text-lg text-slate-600">
                            總支出：<span class="text-red-600 font-bold">@{{ formatCurrency(totalBets * 100) }}</span> 元
                        </p>
                    </div>
                    <div class="p-4 sm:p-6 bg-slate-50 rounded-xl">
                        <p class="text-lg sm:text-xl">獎金總計</p>
                        <p class="text-2xl sm:text-3xl font-bold text-emerald-600">@{{ formatCurrency(totalWinnings) }} 元</p>
                    </div>
                    <div class="p-4 sm:p-6 bg-slate-50 rounded-xl">
                        <p v-if="prizeCount['頭獎'] > 0" 
                           class="text-xl sm:text-2xl text-emerald-600 font-black animate-bounce">
                            挖靠!! 🎉 恭喜中頭獎！
                        </p>
                        <p v-else class="text-lg sm:text-xl text-rose-600">
                            😢 這次沒有中頭獎
                        </p>
                    </div>
                </div>

                <div class="mt-4 sm:mt-6">
                    <p class="text-lg sm:text-xl font-semibold mb-4">收益: <span class="text-red-600">@{{ formatCurrency(lossWin) }}</span> <small>這些錢~你可以拿去吃👇👇👇</small></p>
                    <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                        <li v-for="data in toStores" 
                            class="p-2 sm:p-3 bg-gray-50 rounded-lg text-sm sm:text-base">
                            @{{ data.name }}: <span class="font-semibold">@{{ data.count }}</span> 次
                        </li>
                    </ul>
                </div>

                <div class="mt-4 sm:mt-6">
                    <p class="text-lg sm:text-xl font-semibold mb-4">各獎項中獎次數：</p>
                    <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                        <li v-for="(count, prize) in prizeCount" 
                            :key="prize" 
                            class="p-2 sm:p-3 bg-gray-50 rounded-lg text-sm sm:text-base">
                            @{{ prize }}: <span class="font-semibold">@{{ count }}</span> 次
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 修改再來一次按鈕 -->
            <div class="flex justify-center mt-8 lg:hidden">
                <button @click="resetAndScrollTop" 
                        class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-4 
                               bg-gradient-to-r from-blue-500 to-blue-700 
                               text-white text-lg sm:text-xl font-bold rounded-full
                               shadow-lg hover:shadow-2xl transform hover:-translate-y-1 
                               transition-all duration-300">
                    再來一次
                </button>
            </div>
        </div>
        <p  class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl text-gray-500 p-4 sm:p-8" style="text-align: center">
        無聊玩玩 有問題來信告知 <a href="mailto:qcworkman@gmail.com">qcworkman@gmail.com</a><br />
        copyright © 94ichouo All rights reserved.
        </p>
    </div>

    <script>
        const { createApp, ref, onMounted, computed, watch } = Vue;
        
        createApp({
            setup() {
                const betCount = ref(100); // 用戶輸入的注數
                const winningNumbers = ref([2, 5, 11, 17, 21, 30]); // 設定靜態的開獎號碼，避免計算後更改
                const secondaryNumber = ref(6); // 設定靜態的第二區號碼
                const isCalculating = ref(false);
                const simulationFinished = ref(false);
                const speed = ref(30);
                const totalBets = ref(0);
                const totalWinnings = ref(0);
                const lossWin = ref(0);
                const history = ref([]);
                const toStores = ref([]);
                const winningHistory = ref([]);
                const prizeCount = ref({ "頭獎": 0, "貳獎": 0, "參獎": 0, "肆獎": 0, "伍獎": 0, "陸獎": 0, "柒獎": 0, "捌獎": 0, "玖獎": 0, "普獎": 0 });
                const stores = ref([
                { "name": "茶六燒肉堂", "prize": 2980 }, 
                { "name": "屋馬燒肉", "prize": 2530 }, 
                { "name": "石頭日式炭火燒肉", "prize": 629 }, 
                { "name": "oh yaki燒肉吃到飽崇德店", "prize": 699 }, 
                { "name": "樂軒和牛", "prize": 3000 }, 
                { "name": "燒肉風間 Kazama", "prize": 2500 }, 
                { "name": "瓦庫燒肉", "prize": 2000 }, 
                { "name": "油花迴轉吧燒肉", "prize": 500 }, 
                { "name": "匠屋燒肉 朝馬館", "prize": 2500 }, 
                { "name": "羊角炭火燒肉文心店", "prize": 1169 }, 
                { "name": "八曜和茶", "prize": 60 }, 
                { "name": "吃茶三千", "prize": 70 }, 
                { "name": "Blike", "prize": 65 }, 
                { "name": "春宅", "prize": 75 }, 
                { "name": "紅茶巴士", "prize": 30 }, 
                { "name": "老賴茶棧", "prize": 50 }, 
                { "name": "甲文青 台中健行旗艦店", "prize": 70 }, 
                { "name": "G Colour 金色魔法紅茶", "prize": 80 }, 
                { "name": "理茶 Richa 中美總店", "prize": 65 }, 
                { "name": "阿義紅茶冰", "prize": 40 }, 
                { "name": "萬客什鍋", "prize": 500 }, 
                { "name": "肉多多火鍋", "prize": 600 }, 
                { "name": "無老鍋", "prize": 700 }, 
                { "name": "蜀九品麻辣火鍋", "prize": 650 }, 
                { "name": "老常在麻辣鍋", "prize": 550 }, 
                { "name": "羊鮮森-溫體涮羊肉精緻火鍋", "prize": 750 }, 
                { "name": "蛤?! Huh Pot", "prize": 800 }, 
                { "name": "狂一鍋台式火鍋", "prize": 500 }, 
                { "name": "鼎王麻辣鍋", "prize": 850 }, 
                { "name": "築間", "prize": 600 } 
                ]);

                // 獎金對應的映射
                const prizeMapping = {
                    "頭獎": 1000000000,
                    "貳獎": 2000000,
                    "參獎": 150000,
                    "肆獎": 20000,
                    "伍獎": 4000,
                    "陸獎": 800,
                    "柒獎": 400,
                    "捌獎": 200,
                    "玖獎": 100,
                    "普獎": 100
                };

                // 格式化金額為千分位
                function formatCurrency(amount) {
                    return new Intl.NumberFormat().format(amount);
                }

                // 計算獎金
                function calculatePrize(ticket) {
                    let matchCount = ticket.numbers.filter(n => winningNumbers.value.includes(n)).length;
                    let secondaryMatch = ticket.secondary === secondaryNumber.value;

                    if (matchCount === 6 && secondaryMatch) return { prize: prizeMapping["頭獎"], prizeName: "頭獎" };
                    if (matchCount === 6) return { prize: prizeMapping["貳獎"], prizeName: "貳獎" };
                    if (matchCount === 5 && secondaryMatch) return { prize: prizeMapping["參獎"], prizeName: "參獎" };
                    if (matchCount === 5) return { prize: prizeMapping["肆獎"], prizeName: "肆獎" };
                    if (matchCount === 4 && secondaryMatch) return { prize: prizeMapping["伍獎"], prizeName: "伍獎" };
                    if (matchCount === 4) return { prize: prizeMapping["陸獎"], prizeName: "陸獎" };
                    if (matchCount === 3 && secondaryMatch) return { prize: prizeMapping["柒獎"], prizeName: "柒獎" };
                    if (matchCount === 2 && secondaryMatch) return { prize: prizeMapping["捌獎"], prizeName: "捌獎" };
                    if (matchCount === 3) return { prize: prizeMapping["玖獎"], prizeName: "玖獎" };
                    if (matchCount === 1 && secondaryMatch) return { prize: prizeMapping["普獎"], prizeName: "普獎" };

                    return { prize: 0, prizeName: "未中獎" };
                }

                // 修改滾動到指定元素的函數
                function scrollToElement(elementId) {
                    const element = document.getElementById(elementId);
                    if (element) {
                        // 計算元素到頂部的距離
                        const headerOffset = 0; // 設置為 0 確保完全置頂
                        const elementPosition = element.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                }

                // 修改開始模擬函數
                function startSimulation() {
                    if (betCount.value <= 0 || betCount.value > 5000) return;

                    //判斷超過2000張 速度加快
                    if (betCount.value >= 1000 && betCount.value < 3000) {
                        speed.value = 5;
                    } else if (betCount.value >= 3000) {
                        speed.value = 1;
                    } else {
                        speed.value = 30;
                    }

                    isCalculating.value = true;
                    simulationFinished.value = false;
                    totalBets.value = 0;
                    totalWinnings.value = 0;
                    lossWin.value = 0;
                    history.value = [];
                    toStores.value = [];
                    winningHistory.value = [];
                    prizeCount.value = { "頭獎": 0, "貳獎": 0, "參獎": 0, "肆獎": 0, "伍獎": 0, "陸獎": 0, "柒獎": 0, "捌獎": 0, "玖獎": 0, "普獎": 0 };

                    // 在手機版時，滾動到記錄區域
                    if (window.innerWidth < 1024) {
                        setTimeout(() => {
                            scrollToElement('recordsSection');
                        }, 100);
                    }

                    let currentBet = 0;

                    function runLottery() {
                        if (currentBet < betCount.value) {
                            currentBet++;
                            totalBets.value = currentBet;
                            let ticket = generateWinningNumbers();
                            let prizeGroup = calculatePrize(ticket);

                            totalWinnings.value += prizeGroup.prize;
                            let entry = { id: currentBet, numbers: ticket.numbers, secondary: ticket.secondary, prize: prizeGroup.prize, prizeName: prizeGroup.prizeName };

                            if (prizeGroup.prize > 0) {
                                winningHistory.value.unshift(entry);
                                const prizeKey = Object.keys(prizeMapping).find(key => prizeMapping[key] === prizeGroup.prize);
                                if (prizeKey) prizeCount.value[prizeKey]++;
                            } else {
                                history.value.unshift({ id: currentBet, text: `第 ${currentBet} 注: ${ticket.numbers.join(', ')} + ${ticket.secondary}` });
                            }

                            setTimeout(runLottery, speed.value);
                        } else {
                            simulationFinished.value = true;
                            isCalculating.value = false;
                            lossWin.value = totalWinnings.value - (betCount.value * 100)

                            if (lossWin.value < 0) {
                                computedToStores()
                            }
                            
                            // 計算完成後，滾動到結果區域
                            setTimeout(() => {
                                scrollToElement('resultsSection');
                            }, 300);
                        }
                    }

                    runLottery();
                }

                function computedToStores() {
                    let total = Math.abs(lossWin.value); // 確保金額為正
                    let availableStores = stores.value.filter(store => store.prize <= total); // 過濾出符合金額的店家
                    let selectedStores = {}; // 用來記錄次數

                    while (total > 0 && availableStores.length > 0) {
                        let randomIndex = Math.floor(Math.random() * availableStores.length);
                        let chosenStore = availableStores[randomIndex];

                        if (chosenStore.prize <= total) {
                            if (selectedStores[chosenStore.name]) {
                                selectedStores[chosenStore.name]++;
                            } else {
                                selectedStores[chosenStore.name] = 1;
                            }
                            total -= chosenStore.prize; // 扣除該次消費的金額
                        } else {
                            availableStores.splice(randomIndex, 1); // 若店家價格超出剩餘金額，則移除
                        }
                    }

                    // 轉換成 array 格式
                    toStores.value = Object.entries(selectedStores).map(([name, count]) => ({
                        name,
                        count
                    }));
                }

                // 排序中獎記錄（按獎金由大到小排序）
                const sortedWinningHistory = computed(() => {
                    return [...winningHistory.value].sort((a, b) => b.prize - a.prize);
                });

                // 生成隨機開獎號碼
                function generateWinningNumbers() {
                    let numbers = new Set();
                    while (numbers.size < 6) {
                        numbers.add(Math.floor(Math.random() * 38) + 1);
                    }
                    return { numbers: Array.from(numbers).sort((a, b) => a - b), secondary: Math.floor(Math.random() * 8) + 1 };
                }

                // 頁面一開始就顯示今日開獎
                onMounted(() => {
                    // 這裡會隨機生成今日開獎號碼，只生成一次
                    let { numbers, secondary } = generateWinningNumbers();
                    winningNumbers.value = numbers;
                    secondaryNumber.value = secondary;
                });

                // 顯示中獎號碼顏色
                function getMatchedClass(num) {
                    return winningNumbers.value.includes(num) ? 'matched' : 'not-matched';
                }

                // 顯示第二區的顏色
                function getSecondaryMatchedClass(num) {
                    return num === secondaryNumber.value ? 'matched' : 'not-matched';
                }

                // 修改重置並滾動到頂部的方法
                function resetAndScrollTop() {
                    // 確保滾動到絕對頂部
                    setTimeout(() => {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        
                        // 再次確保到達頂部
                        setTimeout(() => {
                            if (window.pageYOffset > 0) {
                                window.scrollTo(0, 0);
                            }
                        }, 500);
                    }, 0);
                }

                return {
                    betCount,
                    winningNumbers,
                    secondaryNumber,
                    isCalculating,
                    simulationFinished,
                    totalBets,
                    totalWinnings,
                    history,
                    lossWin,
                    stores,
                    toStores,
                    winningHistory,
                    prizeCount,
                    startSimulation,
                    formatCurrency,
                    sortedWinningHistory,
                    scrollToElement,
                    getMatchedClass,
                    getSecondaryMatchedClass,
                    resetAndScrollTop
                };
            }
        }).mount('#app');
    </script>
</body>
</html>

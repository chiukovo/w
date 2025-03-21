<!DOCTYPE html>
<html lang="zh-TW">
@include('layouts.taiwanlottery.main', [
    'title' => '威力彩模擬器 | 台灣彩券分析 + 頭獎機率工具',
    'description' => '試試威力彩模擬下注工具，了解頭獎 1/2,209萬的真實中獎率，助你理性投注、不迷信，享受遊戲樂趣！',
])
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <div id="app" v-cloak>
        @include('layouts.taiwanlottery.header')
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-800 mb-4 sm:mb-6 md:mb-8 mt-2 sm:mt-4 text-center tracking-tight">
                🎲 威力彩下注模擬
            </h1>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-700 mb-6 sm:mb-10 text-center">假設開獎號碼 🎰</h2>
    
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
                            🛒 老闆~我要買威力彩
                        </label>
                        <input type="number" 
                            id="betCount" 
                            v-model="betCount" 
                            min="1" 
                            max="5000" 
                            :disabled="isCalculating"
                            @input="validateInput"
                            class="w-full max-w-[16rem] sm:max-w-xs px-4 py-3 text-lg border border-gray-300 rounded-lg 
                                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                    shadow-sm" />
                        <p class="text-base sm:text-lg text-gray-600 mt-3">
                            老闆: @{{ betCount }}張, 收您：<span class="font-semibold text-blue-600">@{{ formatCurrency(betCount * 100) }}</span> 元
                        </p>
                        <p class="text-base sm:text-lg text-gray-600 mt-3">💡 PS: 頭獎中獎率約1/2209萬</p>
                        <p class="text-base sm:text-lg text-gray-600 mt-3">等同連續2年抽中汽車 🚗</p>
                        <p v-if="betCount > 5000" class="text-rose-500 font-medium text-sm sm:text-base">不可超過 5000 張, 太貴了不要亂花! 💸</p>
                    </div>
    
                    <div class="flex justify-center">
                        <div class="inline-flex items-center">
                          <label class="relative flex items-center cursor-pointer" for="s1">
                            <input name="framework" type="radio" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" id="s1" value="0" v-model="speedStyle">
                            <span class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            </span>
                          </label>
                          <label class="ml-2 text-slate-600 cursor-pointer text-sm" for="s1">一般模式 🐢</label>
                        </div>
                        <div class="inline-flex items-center ml-5">
                          <label class="relative flex items-center cursor-pointer" for="s2">
                            <input name="framework" type="radio" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" id="s2" value="1" v-model="speedStyle">
                            <span class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            </span>
                          </label>
                          <label class="ml-2 text-slate-600 cursor-pointer text-sm" for="s2">加速禮包 🚀</label>
                        </div>
                      </div>
                      <div class="flex justify-center mt-6">
                        <div class="flex flex-col items-center gap-3 w-full sm:w-auto">
                            <button @click="startSimulation" 
                                    :disabled="isCalculating || betCount <= 0 || betCount > 10000"
                                    class="w-full sm:w-auto px-5 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-emerald-500 to-emerald-700 
                                        text-white text-base sm:text-lg font-bold rounded-full
                                        shadow-lg hover:shadow-2xl transform hover:-translate-y-1 
                                        transition-all duration-300 disabled:opacity-50 
                                        disabled:cursor-not-allowed disabled:transform-none">
                                🎰 開始計算
                            </button>
                            @include('layouts.taiwanlottery.share')
                        </div>
                    </div>
                </div>
            </div>
    
            <div v-if="isCalculating" class="text-2xl text-blue-600 text-center animate-pulse font-bold">計算中...🎲</div>
    
            <div id="recordsSection" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-6 sm:mt-8">
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">
                        🏆 中獎記錄
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
                        🎫 投注紀錄
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
                            <p class="text-lg sm:text-xl">威力彩共買了：<strong class="text-xl sm:text-2xl">@{{ totalBets }}</strong> 張</p>
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
                                挖靠!! 🎉 恭喜中頭獎！你是天選之人
                            </p>
                            <p v-else class="text-lg sm:text-xl text-rose-600">
                                好可惜 差一點就中頭獎了(ง •̀_•́)ง
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6">
                        <p class="text-lg sm:text-xl font-semibold mb-4">收益: <span class="text-red-600">@{{ formatCurrency(lossWin) }}</span> 
                            <small v-if="lossWin < 0"> 這些錢~還不如拿去吃👇👇👇</small>
                            <small v-else> 太賽了吧...竟然有賺錢OAO</small>
                        </p>
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
    
            @include('layouts.taiwanlottery.article')
            @include('layouts.taiwanlottery.footer')
        </div>
    </div>
    <script>
        const { createApp, ref, onMounted, computed } = Vue;
        createApp({
            setup() {
                const betCount = ref(100);
                const type = ref('power'); // 根據頁面決定，例如 power, lotto, 539
                const isCalculating = ref(false);
                const simulationFinished = ref(false);
                const totalBets = ref(0);
                const totalWinnings = ref(0);
                const lossWin = ref(0);
                const prizeCount = ref({});
                const winningHistory = ref([]);
                const history = ref([]);
                const toStores = ref([]);
                const speed = ref(30);
                const speedStyle = ref(0);
        
                const stores = ref([
                    { "name": "茶六燒肉堂", "prize": 2980 }, 
                    { "name": "屋馬燒肉", "prize": 2530 }, 
                    { "name": "石頭燒肉", "prize": 629 }, 
                    { "name": "oh yaki燒肉", "prize": 699 }, 
                    { "name": "樂軒和牛", "prize": 3000 }, 
                    { "name": "燒肉風間", "prize": 2500 }, 
                    { "name": "瓦庫燒肉", "prize": 2000 }, 
                    { "name": "油花迴轉吧燒肉", "prize": 500 }, 
                    { "name": "匠屋燒肉", "prize": 2500 }, 
                    { "name": "羊角炭火燒肉", "prize": 1169 }, 
                    { "name": "八曜和茶", "prize": 60 }, 
                    { "name": "吃茶三千", "prize": 70 }, 
                    { "name": "Blike", "prize": 65 }, 
                    { "name": "春宅", "prize": 75 }, 
                    { "name": "紅茶巴士", "prize": 30 }, 
                    { "name": "老賴茶棧", "prize": 50 }, 
                    { "name": "甲文青", "prize": 70 }, 
                    { "name": "金色魔法紅茶", "prize": 80 }, 
                    { "name": "理茶 Richa", "prize": 65 }, 
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
        
                // API 呼叫下注邏輯
                const startSimulation = () => {
                    if (betCount.value <= 0 || betCount.value > 10000) return;
                    isCalculating.value = true;
                    simulationFinished.value = false;
                    totalBets.value = 0;
                    totalWinnings.value = 0;
                    lossWin.value = 0;
                    history.value = [];
                    toStores.value = [];
                    winningHistory.value = [];
                    // 動態速度控制
                    if (speedStyle.value == 1) {
                        speed.value = 0;
                    } else if (betCount.value >= 3000) {
                        speed.value = 1;
                    } else if (betCount.value >= 1000) {
                        speed.value = 3;
                    } else {
                        speed.value = 20;
                    }
        
                    isCalculating.value = true;
                    simulationFinished.value = false;
        
                    axios.post(`/api/bets/${type.value}`, { 
                        betCount: betCount.value,
                        mainNumbers: winningNumbers.value,
                        secondaryNumber: secondaryNumber.value
                    })
                    .then(response => {
                        if (window.innerWidth < 1024) {
                            setTimeout(() => {
                                scrollToElement('recordsSection');
                            }, 100);
                        }
                        const data = response.data;
                        // 基本資料
                        totalBets.value = data.totalBets;
                        totalWinnings.value = data.totalWinnings;
                        lossWin.value = data.netProfit;
                        prizeCount.value = data.prizeCount;

                        let allWins = [...data.winningHistory]; // 有中獎的資料
                        let allLosses = [...data.history]; // 全部下注歷史（包含沒中獎）

                        function runLotteryEffect() {
                            if (allLosses.length > 0) {
                                const currentLoss = allLosses.shift();
                                history.value.unshift(currentLoss);

                                // 如果 allWins 有對應的 id，才一併顯示
                                const winIndex = allWins.findIndex(win => win.id === currentLoss.id);
                                if (winIndex !== -1) {
                                    winningHistory.value.unshift(allWins[winIndex]);
                                    allWins.splice(winIndex, 1);
                                }

                                setTimeout(runLotteryEffect, speed.value);
                            } else {
                                simulationFinished.value = true;
                                isCalculating.value = false;
                                lossWin.value = totalWinnings.value - (betCount.value * 50);

                                if (lossWin.value < 0) {
                                    computedToStores();
                                }

                                    setTimeout(() => {
                                        scrollToElement('resultsSection');
                                    }, 100);
                            }
                        }

                        runLotteryEffect();
                    })
                    .catch(error => {
                        isCalculating.value = false;
                        alert(error.response.data.error)
                    });
                };

                function computedToStores() {
                    let total = Math.abs(lossWin.value);
                    let availableStores = stores.value.filter(store => store.prize <= total);
                    let selectedStores = {};
                    let storeCount = Math.floor(Math.random() * Math.min(6, availableStores.length)) + 1;
                    let remainingAmount = total;
                    let chosenStores = [];
                    while (chosenStores.length < storeCount) {
                    let randomIndex = Math.floor(Math.random() * availableStores.length);
                    let chosenStore = availableStores[randomIndex];
                    if (!chosenStores.includes(chosenStore)) {
                        chosenStores.push(chosenStore);
                    }
                    }
                    let totalStorePrize = chosenStores.reduce((sum, store) => sum + store.prize, 0);
                    chosenStores.forEach(store => {
                    let proportion = store.prize / totalStorePrize;
                    let assignedCount = Math.floor(remainingAmount * proportion / store.prize);
                    assignedCount = Math.min(assignedCount, Math.floor(remainingAmount / store.prize));
                    selectedStores[store.name] = assignedCount;
                    remainingAmount -= assignedCount * store.prize;
                    });
                    if (remainingAmount > 0 && storeCount > 0) {
                    let remainingAmountPerStore = Math.floor(remainingAmount / storeCount);
                    chosenStores.forEach(store => {
                        let additionalCount = Math.floor(remainingAmountPerStore / store.prize);
                        selectedStores[store.name] += additionalCount;
                    });
                    }
                    let totalAssignedAmount = Object.entries(selectedStores).reduce((sum, [name, count]) => sum + stores.value.find(store => store.name === name).prize * count, 0);
                    if (totalAssignedAmount > total) {
                    console.log("分配數量超過了收益，將進行調整！");
                    let excessAmount = totalAssignedAmount - total;
                    for (let store in selectedStores) {
                        if (excessAmount <= 0) break;
                        let storeAmount = selectedStores[store] * stores.value.find(storeData => storeData.name === store).prize;
                        let adjustment = Math.min(storeAmount, excessAmount);
                        selectedStores[store] -= Math.floor(adjustment / stores.value.find(storeData => storeData.name === store).prize);
                        excessAmount -= adjustment;
                    }
                    }
                    toStores.value = Object.entries(selectedStores).map(([name, count]) => ({
                    name,
                    count
                    }));
                }

                function switchGame(game) {
                    if (game == '威力彩') {
                        location.href = '/';
                    } else if (game == '今彩539') {
                        location.href = '/taiwanlottery/539';
                    } else if (game == '大樂透') {
                        location.href = '/taiwanlottery/lotto';
                    }
                }
        
                // 滾動到指定位置
                const scrollToElement = (elementId) => {
                    const element = document.getElementById(elementId);
                    if (element) {
                        const offsetPosition = element.getBoundingClientRect().top + window.pageYOffset;
                        window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                    }
                };
        
                const formatCurrency = (amount) => new Intl.NumberFormat().format(amount);
        
                const validateInput = (event) => {
                    let value = event.target.value;
                    value = value.replace(/\D/g, "");
                    betCount.value = value;
                };
        
                const resetAndScrollTop = () => {
                    setTimeout(() => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        setTimeout(() => { if (window.pageYOffset > 0) window.scrollTo(0, 0); }, 500);
                    }, 0);
                };
        
                const sortedWinningHistory = computed(() => {
                    return [...winningHistory.value].sort((a, b) => b.prize - a.prize);
                });
        
                // 自動生成開獎號碼 (供前端顯示用)
                const winningNumbers = ref([]);
                const secondaryNumber = ref(null);
                onMounted(() => {
                    const numbers = new Set();
                    while (numbers.size < 6) numbers.add(Math.floor(Math.random() * 38) + 1);
                    winningNumbers.value = Array.from(numbers).sort((a, b) => a - b);
                    secondaryNumber.value = Math.floor(Math.random() * 8) + 1;
                });
        
                const getMatchedClass = (num) => winningNumbers.value.includes(num) ? 'matched' : 'not-matched';
                const getSecondaryMatchedClass = (num) => num === secondaryNumber.value ? 'matched' : 'not-matched';
        
                return {
                    betCount,
                    type,
                    isCalculating,
                    simulationFinished,
                    totalBets,
                    totalWinnings,
                    lossWin,
                    prizeCount,
                    winningHistory,
                    history,
                    stores,
                    toStores,
                    switchGame,
                    speed,
                    speedStyle,
                    startSimulation,
                    formatCurrency,
                    validateInput,
                    sortedWinningHistory,
                    scrollToElement,
                    computedToStores,
                    resetAndScrollTop,
                    winningNumbers,
                    secondaryNumber,
                    getMatchedClass,
                    getSecondaryMatchedClass
                };
            }
        }).mount('#app');
    </script>
    
</body>
</html>

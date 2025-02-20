<!DOCTYPE html>
<html lang="zh-TW">
  @include('layouts.taiwanlottery')
  <body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen p-4 sm:p-6 md:p-8">
    <div id="app" class="max-w-7xl mx-auto" v-cloak>
      <header class="bg-blue-500 shadow flex gap-2">
        <div class="dropdown">
            <label for="gameSelect" class="sr-only">選擇其他遊戲</label>
            <select id="gameSelect" @change="switchGame($event.target.value)" class="bg-blue-500 text-white px-2 py-2 rounded-0">
                <option value="" disabled selected>選擇其他遊戲</option>
                <option value="威力彩">威力彩</option>
                <option value="大樂透">大樂透</option>
            </select>
        </div>
        <div class="marquee flex items-center w-full">
            <p class="text-blue-300">網站內所有產生出來的號碼均為虛擬及假設，並非真實性內容，請勿沉迷及非法行動，本網站只提供工具交流，並無提供金錢買賣及任何交易。</p>
        </div>
      </header>
      <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-800 mb-4 sm:mb-6 md:mb-8 mt-2 sm:mt-4 text-center tracking-tight"> 今彩539下注模擬 </h1>
        <h2 class="text-xl sm:text-2xl font-bold text-slate-700 mb-6 sm:mb-10 text-center">假設開獎號碼</h2>
        <div class="flex justify-center flex-wrap gap-2 sm:gap-3 mb-8 sm:mb-12">
          <span v-for="(num, index) in winningNumbers" :key="num" :class="[ 'flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-full',
                      'bg-gradient-to-br from-amber-400 to-amber-600',
                      'text-white text-lg sm:text-2xl font-bold shadow-xl',
                      'hover:scale-110 transition-all duration-300',
                      `float-delay-${index}` ]"> @{{ num }}
          </span>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 md:p-8 mb-6 sm:mb-8">
          <div class="space-y-4">
            <div class="flex flex-col items-center">
              <label for="betCount" class="text-lg sm:text-xl font-semibold text-gray-700 mb-3 text-center"> 老闆~我要買今彩539 </label>
              <input type="number" id="betCount" v-model="betCount" min="1" max="5000" :disabled="isCalculating" @input="validateInput" class="w-full max-w-[16rem] sm:max-w-xs px-4 py-3 text-lg border border-gray-300 rounded-lg 
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              shadow-sm" />
              <p class="text-base sm:text-lg text-gray-600 mt-3"> 老闆: @{{ betCount }}張, 收您： <span class="font-semibold text-blue-600">@{{ formatCurrency(betCount * 50) }}</span> 元 </p>
              <p class="text-base sm:text-lg text-gray-600 mt-3">頭獎中獎率約1/58萬, 有夢最美</p>
              <p v-if="betCount > 5000" class="text-rose-500 font-medium text-sm sm:text-base">不可超過 5000 張, 太貴了不要亂花!</p>
            </div>
            <div class="flex justify-center mt-6">
              <button @click="startSimulation" :disabled="isCalculating || betCount <= 0 || betCount > 10000" class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-4 bg-gradient-to-r from-emerald-500 to-emerald-700 
                              text-white text-lg sm:text-xl font-bold rounded-full
                              shadow-lg hover:shadow-2xl transform hover:-translate-y-1 
                              transition-all duration-300 disabled:opacity-50 
                              disabled:cursor-not-allowed disabled:transform-none"> 開始計算 </button>
            </div>
          </div>
        </div>
        <div v-if="isCalculating" class="text-2xl sm:text-3xl text-blue-600 text-center mt-6 sm:mt-8 animate-pulse font-bold"> 計算中... </div>
        <div id="recordsSection" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-6 sm:mt-8">
          <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4"> 中獎記錄 </h3>
            <div class="h-[240px] lg:h-[160px] sm:h-[300px] overflow-y-auto space-y-2 text-sm sm:text-base">
              <p v-for="result in sortedWinningHistory" :key="result.id" class="p-2 sm:p-3 bg-green-50 rounded-lg">
                <span class="font-medium">第 @{{ result.id }} 注: </span>
                <span v-for="(num, index) in result.numbers" :key="index" class="font-semibold">
                  <span :class="getMatchedClass(num)"> @{{ num }}</span>
                  <span v-if="index < result.numbers.length - 1">, </span>
                </span>
                <span class="block sm:inline sm:ml-2 text-emerald-600 font-semibold"> @{{ result.prizeName }}: @{{ formatCurrency(result.prize) }} 元 </span>
              </p>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4"> 投注紀錄 </h3>
            <div class="h-[240px] lg:h-[160px] sm:h-[300px] overflow-y-auto space-y-2 text-sm sm:text-base">
              <p v-for="result in history" :key="result.id" class="p-2 sm:p-3 bg-gray-50 rounded-lg" :class="{'text-red-500 font-bold': result.prize === 0}"> @{{ result.text }}
              </p>
            </div>
          </div>
        </div>
        <div v-if="simulationFinished" id="resultsSection" class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl p-4 sm:p-8 mb-10">
          <div class="space-y-4 sm:space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
              <div class="p-4 sm:p-6 bg-slate-50 rounded-xl">
                <p class="text-lg sm:text-xl">今彩539共買了： <strong class="text-xl sm:text-2xl">@{{ totalBets }}</strong> 張 </p>
                <p class="text-base sm:text-lg text-slate-600"> 總支出： <span class="text-red-600 font-bold">@{{ formatCurrency(totalBets * 50) }}</span> 元 </p>
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
                <small v-if="lossWin < 0"> 這些錢~還不如拿去吃👇👇👇 </small>
                <small v-else> 太賽了吧...竟然有賺錢OAO</small>
              </p>
              <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                <li v-for="data in toStores" class="p-2 sm:p-3 bg-gray-50 rounded-lg text-sm sm:text-base"> @{{ data.name }}: <span class="font-semibold">@{{ data.count }}</span> 次 </li>
              </ul>
            </div>
            <div class="mt-4 sm:mt-6">
              <p class="text-lg sm:text-xl font-semibold mb-4">各獎項中獎次數：</p>
              <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                <li v-for="(count, prize) in prizeCount" :key="prize" class="p-2 sm:p-3 bg-gray-50 rounded-lg text-sm sm:text-base"> @{{ prize }}: <span class="font-semibold">@{{ count }}</span> 次 </li>
              </ul>
            </div>
          </div>
          <!-- 修改再來一次按鈕 -->
          <div class="flex justify-center mt-8 lg:hidden">
            <button @click="resetAndScrollTop" class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-4 
                          bg-gradient-to-r from-blue-500 to-blue-700 
                          text-white text-lg sm:text-xl font-bold rounded-full
                          shadow-lg hover:shadow-2xl transform hover:-translate-y-1 
                          transition-all duration-300"> 再來一次 </button>
          </div>
        </div>
        <p class="mt-8 sm:mt-12 bg-white rounded-2xl shadow-xl text-gray-500 p-4 sm:p-8" style="text-align: center"> 無聊玩玩 有問題來信告知 <a href="mailto:qcworkman@gmail.com">qcworkman@gmail.com</a>
          <br /> copyright © chiuko All rights reserved.
        </p>
      </div>
    </div>
    <script>
      const {
        createApp,
        ref,
        onMounted,
        computed,
        watch
      } = Vue;
      createApp({
        setup() {
          const betCount = ref(100); // 用戶輸入的注數
          const winningNumbers = ref([]); // 設定靜態的開獎號碼，避免計算後更改
          const isCalculating = ref(false);
          const simulationFinished = ref(false);
          const totalBets = ref(0);
          const totalWinnings = ref(0);
          const lossWin = ref(0);
          const history = ref([]);
          const toStores = ref([]);
          const winningHistory = ref([]);
          const prizeCount = ref({
            "頭獎": 0,
            "貳獎": 0,
            "參獎": 0,
            "肆獎": 0
          });
          const stores = ref([{
            "name": "茶六燒肉堂",
            "prize": 2980
          }, {
            "name": "屋馬燒肉",
            "prize": 2530
          }, {
            "name": "石頭燒肉",
            "prize": 629
          }, {
            "name": "oh yaki燒肉",
            "prize": 699
          }, {
            "name": "樂軒和牛",
            "prize": 3000
          }, {
            "name": "燒肉風間",
            "prize": 2500
          }, {
            "name": "瓦庫燒肉",
            "prize": 2000
          }, {
            "name": "油花迴轉吧燒肉",
            "prize": 500
          }, {
            "name": "匠屋燒肉",
            "prize": 2500
          }, {
            "name": "羊角炭火燒肉",
            "prize": 1169
          }, {
            "name": "八曜和茶",
            "prize": 60
          }, {
            "name": "吃茶三千",
            "prize": 70
          }, {
            "name": "Blike",
            "prize": 65
          }, {
            "name": "春宅",
            "prize": 75
          }, {
            "name": "紅茶巴士",
            "prize": 30
          }, {
            "name": "老賴茶棧",
            "prize": 50
          }, {
            "name": "甲文青",
            "prize": 70
          }, {
            "name": "金色魔法紅茶",
            "prize": 80
          }, {
            "name": "理茶 Richa",
            "prize": 65
          }, {
            "name": "阿義紅茶冰",
            "prize": 40
          }, {
            "name": "萬客什鍋",
            "prize": 500
          }, {
            "name": "肉多多火鍋",
            "prize": 600
          }, {
            "name": "無老鍋",
            "prize": 700
          }, {
            "name": "蜀九品麻辣火鍋",
            "prize": 650
          }, {
            "name": "老常在麻辣鍋",
            "prize": 550
          }, {
            "name": "羊鮮森-溫體涮羊肉精緻火鍋",
            "prize": 750
          }, {
            "name": "蛤?! Huh Pot",
            "prize": 800
          }, {
            "name": "狂一鍋台式火鍋",
            "prize": 500
          }, {
            "name": "鼎王麻辣鍋",
            "prize": 850
          }, {
            "name": "築間",
            "prize": 600
          }]);
          const prizeMapping = {
            "頭獎": 8000000,
            "貳獎": 20000,
            "參獎": 300,
            "肆獎": 50
          };
          // 格式化金額為千分位
          function formatCurrency(amount) {
            return new Intl.NumberFormat().format(amount);
          }
          // 計算獎金
          function calculatePrize(ticket) {
            let matchCount = ticket.numbers.filter(n => winningNumbers.value.includes(n)).length;
            if (matchCount === 5) return {
              prize: prizeMapping["頭獎"],
              prizeName: "頭獎"
            };
            if (matchCount === 4) return {
              prize: prizeMapping["貳獎"],
              prizeName: "貳獎"
            };
            if (matchCount === 3) return {
              prize: prizeMapping["參獎"],
              prizeName: "參獎"
            };
            if (matchCount === 2) return {
              prize: prizeMapping["肆獎"],
              prizeName: "肆獎"
            };
            return {
              prize: 0,
              prizeName: "未中獎"
            };
          }
          // 顯示號碼顏色
          function getMatchedClass(num) {
            return winningNumbers.value.includes(num) ? 'matched' : 'not-matched';
          }

          function getSecondaryMatchedClass(num) {
            return num === winningNumbers.value[4] ? 'matched' : 'not-matched'; // 假設第五個是特別號
          }
          // 修改滾動到指定元素的函數
          function scrollToElement(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
              const elementPosition = element.getBoundingClientRect().top;
              const offsetPosition = elementPosition + window.pageYOffset;
              window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
              });
            }
          }
          // 開始模擬
          function startSimulation() {
            if (betCount.value <= 0 || betCount.value > 5000) return;
            isCalculating.value = true;
            simulationFinished.value = false;
            totalBets.value = 0;
            totalWinnings.value = 0;
            lossWin.value = 0;
            history.value = [];
            toStores.value = [];
            winningHistory.value = [];
            prizeCount.value = {
              "頭獎": 0,
              "貳獎": 0,
              "參獎": 0,
              "肆獎": 0
            };
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
                let entry = {
                  id: currentBet,
                  numbers: ticket.numbers,
                  prize: prizeGroup.prize,
                  prizeName: prizeGroup.prizeName
                };
                if (prizeGroup.prize > 0) {
                  winningHistory.value.unshift(entry);
                  const prizeKey = Object.keys(prizeMapping).find(key => prizeMapping[key] === prizeGroup.prize);
                  if (prizeKey) prizeCount.value[prizeKey]++;
                } else {
                  history.value.unshift({
                    id: currentBet,
                    text: `第 ${currentBet} 注: ${ticket.numbers.join(', ')}`
                  });
                }
                setTimeout(runLottery, 20);
              } else {
                simulationFinished.value = true;
                isCalculating.value = false;
                lossWin.value = totalWinnings.value - (betCount.value * 50);
                if (lossWin.value < 0) {
                  computedToStores();
                }
                setTimeout(() => {
                  scrollToElement('resultsSection');
                }, 300);
              }
            }
            runLottery();
          }
          // 切换游戏方法
          function switchGame(game) {
              if (game == '威力彩') {
                  location.href = '/taiwanlottery';
              } else if (game == '大樂透') {
                  location.href = '/taiwanlottery/lotto';
              }
          }
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

          onMounted(() => {
            let {
              numbers
            } = generateWinningNumbers();
            winningNumbers.value = numbers;
          });

          function generateWinningNumbers() {
            let numbers = new Set();
            while (numbers.size < 5) {
              numbers.add(Math.floor(Math.random() * 39) + 1); // 1~39
            }
            return {
              numbers: Array.from(numbers).sort((a, b) => a - b)
            };
          }
          // 驗證輸入
          const validateInput = (event) => {
            let value = event.target.value;
            value = value.replace(/\D/g, "");
            betCount.value = value;
          };
          const sortedWinningHistory = computed(() => {
            return [...winningHistory.value].sort((a, b) => b.prize - a.prize);
          });

          function resetAndScrollTop() {
            setTimeout(() => {
              window.scrollTo({
                top: 0,
                behavior: 'smooth'
              });
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
            isCalculating,
            resetAndScrollTop,
            simulationFinished,
            totalBets,
            totalWinnings,
            switchGame,
            history,
            lossWin,
            validateInput,
            stores,
            toStores,
            winningHistory,
            prizeCount,
            startSimulation,
            formatCurrency,
            sortedWinningHistory,
            getMatchedClass,
            getSecondaryMatchedClass
          };
        }
      }).mount('#app');
    </script>
  </body>
</html>
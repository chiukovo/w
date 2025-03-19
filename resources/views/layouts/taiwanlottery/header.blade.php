<header class="bg-blue-500 shadow flex gap-2">
    <div class="dropdown">
        <label for="gameSelect" class="sr-only">選擇其他遊戲</label>
        <select id="gameSelect" @change="switchGame($event.target.value)" class="bg-blue-500 text-white px-2 py-2 rounded-0">
            <option value="" disabled selected>選擇其他遊戲</option>
            <option value="威力彩">威力彩</option>
            <option value="大樂透">大樂透</option>
            <option value="今彩539">今彩539</option>
        </select>
    </div>
    <div class="marquee flex items-center w-full">
        <p class="text-blue-300">網站內所有產生出來的號碼均為虛擬及假設，並非真實性內容，請勿沉迷及非法行動，本網站只提供工具交流，並無提供金錢買賣及任何交易。</p>
    </div>
  </header>
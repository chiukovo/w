@php
$user = auth()->user();
@endphp

<header class="bg-blue-600 shadow px-4 py-3">
  <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 sm:gap-4">

    <!-- 🎮 左側：選單與按鈕 -->
    <div class="flex items-center gap-2 flex-wrap">
      <select id="gameSelect"
        class="bg-blue-700 text-white text-xs px-2 py-1 rounded border border-blue-800 focus:outline-none">
        <option value="" disabled selected>選擇遊戲</option>
        <option>威力彩</option>
        <option>大樂透</option>
        <option>今彩539</option>
      </select>

      <a href="/taiwanlottery/articles"
        class="bg-white text-blue-600 text-xs px-3 py-1.5 rounded shadow-sm hover:bg-blue-50 transition whitespace-nowrap">
        📚 密技
      </a>

      <a id="rankBtn" href="#"
        class="bg-white text-blue-600 text-xs px-3 py-1.5 rounded shadow-sm hover:bg-blue-50 transition whitespace-nowrap relative">
        🏅 排行
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] px-1 rounded-full">NEW</span>
      </a>
    </div>

    <!-- 👤 右側：登入狀態 -->
    <div id="user-controls" class="flex items-center gap-2 text-xs text-white ml-auto">
      @if ($user)
        <button type="button"
          class="border border-white rounded px-2 py-1 max-w-[110px] overflow-hidden whitespace-nowrap text-ellipsis hover:bg-white hover:text-blue-600 transition"
          title="Hi ~ {{ $user->nickname }}">
          {{ $user->nickname }}
        </button>
        <button id="logoutBtn"
          class="border border-white rounded px-2 py-1 hover:bg-white hover:text-blue-600 transition">
          登出
        </button>
      @else
        <button id="loginBtn"
          class="border border-white rounded px-2 py-1 hover:bg-white hover:text-blue-600 transition">
          登入
        </button>
        <button id="registerBtn"
          class="bg-yellow-400 text-blue-800 rounded px-2 py-1 hover:bg-yellow-300 transition">
          註冊
        </button>
      @endif
    </div>

  </div>
</header>

<!-- 排行榜 Modal -->
<div id="rankModal" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50 opacity-0 transition-opacity duration-300">
  <div class="bg-white rounded-lg w-full max-w-xl p-4 shadow-lg scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
    <h2 class="text-lg font-bold text-center text-blue-600 mb-4">
      🏅 <span id="rankingGameName">威力彩</span> 排行榜
    </h2>
    <table class="w-full text-sm text-center">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="py-2">#</th>
          <th class="py-2">玩家</th>
          <th class="py-2">注數</th>
          <th class="py-2">中獎</th>
        </tr>
      </thead>
      <tbody id="rankTableBody">
        <!-- JS 插入資料 -->
      </tbody>
    </table>
    <div class="flex justify-end mt-4">
      <button id="closeRank" class="px-4 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-500">關閉</button>
    </div>
  </div>
</div>
<!-- Modal 登入/註冊 -->
<div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50 opacity-0 transition-opacity duration-300">
  <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg scale-95 transition-transform duration-300">
    <h2 id="modalTitle" class="text-xl font-bold mb-4">登入</h2>
    <div class="space-y-3">
      <input type="text" id="account" class="w-full border rounded px-3 py-2" placeholder="帳號 (長度 2~8)">
      <input type="password" id="password" class="w-full border rounded px-3 py-2" placeholder="密碼(長度 4~20)">
      <div id="registerFields" class="hidden">
        <input type="password" id="password_confirmation" class="w-full border rounded px-3 py-2" placeholder="再次輸入密碼(長度 4~20)">
        <input type="text" id="nickname" class="w-full border rounded px-3 py-2" placeholder="暱稱(長度 1~10)">
      </div>
    </div>
    <div class="flex justify-end mt-4 gap-2">
      <button id="cancelBtn" class="text-sm px-4 py-1 rounded border">取消</button>
      <button id="submitBtn" class="text-sm px-4 py-1 rounded bg-blue-600 text-white hover:bg-blue-500 transition">送出</button>
    </div>
  </div>
</div>


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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logoutBtn')
    if (logoutBtn) {
      logoutBtn.addEventListener('click', () => {
        fetch('/api/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
        })
        .then(() => {
          location.reload()
        })
        .catch(err => {
          alert('登出錯誤：' + err.message)
        })
      })
    }

    const modal = document.getElementById('modal')
    const loginBtn = document.getElementById('loginBtn')
    const registerBtn = document.getElementById('registerBtn')
    const cancelBtn = document.getElementById('cancelBtn')
    const submitBtn = document.getElementById('submitBtn')
    const modalTitle = document.getElementById('modalTitle')
    const registerFields = document.getElementById('registerFields')
    const closeRank = document.getElementById('closeRank')

    let isLoginMode = true

    if (loginBtn) {
      loginBtn.addEventListener('click', () => openModal(true))
    }

    if (registerBtn) {
      registerBtn.addEventListener('click', () => openModal(false))
    }

    cancelBtn.addEventListener('click', closeModal)
    submitBtn.addEventListener('click', handleSubmit)
    closeRank.addEventListener('click', closeRankModal)

    const rankModal = document.getElementById('rankModal')
    const rankBtn = document.getElementById('rankBtn')

    if (rankBtn) {
      rankBtn.addEventListener('click', (e) => {
        e.preventDefault()
        openRankModal()
      })
    }

    function openRankModal() {
      const pathname = location.pathname

      let selectedGame = '威力彩' // 預設
      if (pathname.includes('/lotto')) {
        selectedGame = '大樂透'
      } else if (pathname.includes('/539')) {
        selectedGame = '今彩539'
      }

      const gameNameSpan = document.getElementById('rankingGameName')
      if (gameNameSpan) gameNameSpan.textContent = selectedGame

      fetch(`/api/rankings/win-rate?game=${encodeURIComponent(selectedGame)}`)
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById('rankTableBody')
          tbody.innerHTML = ''
          data.forEach((row, index) => {
            const tr = document.createElement('tr')
            tr.innerHTML = `
              <td class="py-2">${index + 1}</td>
              <td class="py-2">${row.nickname}</td>
              <td class="py-2">${row.bet_count}</td>
              <td class="py-2 text-green-600">${row.total_win}</td>
            `
            tbody.appendChild(tr)
          })

          rankModal.classList.remove('hidden')
          setTimeout(() => {
            rankModal.classList.add('flex')
            rankModal.classList.remove('opacity-0')
          }, 10)
        })
        .catch(err => alert('排行載入失敗：' + err.message))
    }

    function closeRankModal() {
      rankModal.classList.add('opacity-0')
      rankModal.classList.remove('flex')
      rankModal.classList.add('hidden')
    }

    function openModal(loginMode) {
      isLoginMode = loginMode

      const modal = document.getElementById('modal')
      const registerFields = document.getElementById('registerFields')
      const modalTitle = document.getElementById('modalTitle')

      modal.classList.remove('hidden')
      setTimeout(() => {
        modal.classList.add('flex')
        modal.classList.remove('opacity-0')
      }, 10) // small delay for transition to work

      modalTitle.textContent = isLoginMode ? '登入' : '註冊'
      registerFields.classList.toggle('hidden', isLoginMode)
    }

    function closeModal() {
      const modal = document.getElementById('modal')
      modal.classList.add('opacity-0')
      modal.classList.remove('flex')
      modal.classList.add('hidden')
    }

    function handleSubmit() {
      const account = document.getElementById('account').value.trim()
      const password = document.getElementById('password').value.trim()
      const nickname = document.getElementById('nickname')?.value.trim()
      const password_confirmation = document.getElementById('password_confirmation')?.value.trim()

      if (!account || !password) {
        alert('帳號或密碼未填')
        return
      }

      if (!isLoginMode) {
        if (!nickname) {
          alert('暱稱未填')
          return
        }
        if (password !== password_confirmation) {
          alert('兩次密碼不一致')
          return
        }
      }

      const url = isLoginMode ? '/api/login' : '/api/signIn'
      const payload = isLoginMode
        ? { account, password }
        : { account, password, nickname, password_confirmation }

      fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      })
        .then(async res => {
          if (!res.ok) {
            const data = await res.json()
            throw new Error(data.message || '操作失敗')
          }
          return res.json()
        })
        .then(() => {
          alert('登入成功')
          location.reload()
        })
        .catch(err => {
          alert(`錯誤：${err.message}`)
        })
    }
    
    // 可選：遊戲切換事件
    document.getElementById('gameSelect').addEventListener('change', (e) => {
      const game = e.target.value
      if (game == '威力彩') {
          location.href = '/';
      } else if (game == '今彩539') {
          location.href = '/taiwanlottery/539';
      } else if (game == '大樂透') {
          location.href = '/taiwanlottery/lotto';
      }
    })
  })
</script>
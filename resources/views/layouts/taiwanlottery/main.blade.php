<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{ $title ?? '彩券下注模擬玩玩看 | 免費模擬器與中獎率分析' }}</title>
  <meta name="description" content="{{ $description ?? '模擬下注、分析中獎機率，幫助你理性購買今彩539、大樂透、威力彩等彩券，免費統計工具讓你玩得更安心。' }}">
  <meta name="keywords" content="{{ $keywords ?? '今彩539, 大樂透, 威力彩, 中獎機率, 模擬下注, 彩券分析, 樂透模擬器, 理性投注, 樂透統計, 彩券數據, 彩券模擬' }}">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:title" content="{{ $title ?? '彩券下注模擬玩玩看 | 免費模擬器與中獎率分析' }}">
  <meta property="og:description" content="{{ $description ?? '模擬下注、了解彩券頭獎中獎機率，助你理性投注不迷信！免費工具立即體驗。' }}">
  <meta property="og:image" content="{{ asset('/img/default.webp') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🎲</text></svg>">
  
  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $title ?? '彩券下注模擬玩玩看 | 免費模擬器與中獎率分析' }}">
  <meta name="twitter:description" content="{{ $description ?? '模擬下注、了解彩券頭獎中獎機率，助你理性投注不迷信！免費工具立即體驗。' }}">
  <meta name="twitter:image" content="{{ asset('/img/default.webp') }}">
  <link rel="canonical" href="{{ url()->current() }}" />
  <script src="/js/vue.global.prod.js"></script>
  <script src="/js/tailwindcss_4.js"></script>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-D4DRBBS5S0"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-D4DRBBS5S0');
  </script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2560043137442562" crossorigin="anonymous"></script>
  
  <style>
    [v-cloak] { display: none; }
    .matched { color: red; }
    .dropdown { position: relative; display: inline-block; }
    .dropdown-content { display: none; position: absolute; background-color: white; min-width: 160px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; }
    .dropdown:hover .dropdown-content { display: block; }
    .marquee { overflow: hidden; white-space: nowrap; box-sizing: border-box; }
    .marquee p { display: inline-block; animation: marquee 20s linear infinite; }
    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
  </style>

  @yield('head-extra')
</head>

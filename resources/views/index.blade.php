<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"  content="在課金之前 先來試試手氣吧! 自製天堂w抽卡 0元免費抽" />
	<title>94i抽 - 天堂W模擬抽卡</title>
	<link rel="stylesheet" href="/css/aos.css" />
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css?v=3">
	<link rel="stylesheet" href="/css/lity.min.css">
</head>

<body>
	<div id="app" v-cloak>
		<header>
			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
				<a class="navbar-brand" href="#">94i抽 - 天堂W模擬抽卡</a>
			</nav>
		</header>

		<!-- Begin page content -->
		<main role="main" class="container-xl" style="position: relative;z-index: 1">
			<div>
				<div v-if="items.length == 0">
					<section class="jumbotron" style="margin-top: 50px;">
						<div class="container" style="text-align: left;">
							<div class="media">
								<img src="/img/gyman.jpg" class="align-self-start mr-3 img-thumbnail rounded">
									<div class="media-body">
										<h5 class="mt-0">GYMAN</h5>
										<p>小朋友們, 這遊戲很可怕的, 錢不好賺, 不要學網路上的叔叔們花大錢抽卡</p>
										<p>先來這抽抽看, 試試臉黑不黑( ^.＜ ) </p>
										<p>抽完之後告訴我, <span class="text-danger" style="font-size: 20px;">你還想抽卡嗎???</span></p>
									</div>
							</div>
						</div>
					</section>
				</div>
				<div class="row">
					<div class="col-4 col-lg-3 mb-2" 
						v-for="(item, index) in items"
						v-if="items.length"
						:data-aos="!isCardOpen ? 'fade-down' : ''"
						:data-aos-delay="index * 50"
						@click="cardClick(item)"
					>
						<div
							class="card item"
							:class="item.flip ? 'flip' : ''"
						>
							<div class="face front" :class="item.gradeId > 2 ? 'surprise' : ''" :style="checkCardBg(item)">
							</div>
							<div class="face back" :class="['g-' + item.gradeId, item.gradeId > 2 ? 'surprise' : '']">
								<div class="img_content" :class="'gb-' + item.gradeId">
									<img src="/img/in.jpg" :alt="item.name" v-if="item.image == ''" class="img-in" />
									<img :src="item.image" :alt="item.name" v-else />
								</div>
								<div class="description">
									@{{ item.name }}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="inline" class="lity-hide">
					<div class="in_content">
						<div class="in_banners" :style="computedResultBanner()" style="box-shadow: 6px 6px 9px black;"></div>

						<div class="card item card_in" v-if="detail != ''" :class="detail.flip ? 'flip' : ''" @click="openDetail()" style="position: relative;left: 27%;">
							<div class="face front" :class="detail.gradeId > 2 ? 'surprise' : ''" style="background-image: url('/img/nice.jpg')">
								<h2><small></small></h2>
							</div>
							<div class="face back" :class="['g-' + detail.gradeId, detail.gradeId > 2 ? 'surprise' : '']">
								<div class="img_content" :class="'gb-' + detail.gradeId">
									<img src="/img/in.jpg" :alt="detail.name" v-if="detail.image == ''" style="height: 160px;"/>
									<img :src="detail.image" :alt="detail.name" v-else />
								</div>
								<div class="description">
									@{{ detail.name }}
								</div>
							</div>
						</div>
						<p class="h1 text-danger text-center">
							@{{ result_text }}
						</p>
					</div>
				</div>
				<!--統計-->
				<div class="mt-4" style="background-color: #eee;">
					<table class="table table-dark">
						<thead>
							<tr>
								<th></th>
								<th>抽到數量</th>
								<th>抽到機率</th>
								<th>官方機率</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="data in rate">
								<td>
									<span :class="'g-' + data.gradeId">@{{ data.name }}</span>
								</td>
								<td>@{{ data.count }}</td>
								<td>@{{ data.myProbability }}%</td>
								<td>@{{ data.probability }}%</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="alert alert-warning" role="alert">
					<div class="rate">
						機率:
						<span v-for="data in rate">@{{ data.name }}: @{{ data.probability }}%</span>
					</div>
				</div>
			</div>
		</main>

		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="f-button-div">
							<button type="button" class="btn btn-primary btn-lg shadow-lg p-3 mb-5 rounded" @click="lottery" v-if="!start" :disabled="loading">上級變身抽卡11次</button>
							<button type="button" class="btn btn-danger btn-lg shadow-lg p-3 mb-5 rounded" @click="allOpen" v-else :disabled="loading">
								<span v-if="isAllOpen">全部開啟٩(^ᴗ^)۶</span>
								<span v-else>牙起來牙起來!!</span>
							</button>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<ul class="list-group list-group-flush" style="margin: 20px;">
							<li class="list-group-item">已抽次數: <span>@{{ numberDraws }}</span></li>
							<li class="list-group-item">
                花費鑽石: <span>@{{ 1200 * numberDraws }} = 台幣 @{{ 750 * numberDraws }}</span>
                <br><small class="text-muted">@{{ ps_memo }}</small>
              </li>
							<li class="list-group-item">
								<span v-for="data in rate" style="padding-right: 5px;" >@{{ data.name }}: @{{ data.count }}</span>
							</li>
						</ul>
					</div>
				</div>
				<p class="memo">
					本站無任何營利 如有任何侵權 請來信告知 <a href="mailto:qcworkman@gmail.com">qcworkman@gmail.com</a><br>
					copyright © QUNIIII All rights reserved.
				</p>
			</div>
		</footer>
	</div>
</body>
<script src="/js/jquery.js"></script>
<script src="/js/vue.min.js"></script>
<script src="/js/axios.min.js"></script>
<script src="/js/aos.js"></script>
<script src="/js/lity.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-D4DRBBS5S0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-D4DRBBS5S0');
</script>
<script>
	new Vue({
		el: '#app',
		data: {
			flip: false,
			loading: false,
			isCardOpen: false,
			items: [],
			detail: '',
			rate: [],
			start: false,
			isAllOpen: true,
			numberDraws: 0,
			result_text: '',
      ps_memo: '',
		},
		mounted() {
			AOS.init({ disable: 'mobile' });
			this.getRate()
		},
		watch: {
      numberDraws(num) {

      },
			start(type) {
				if (!type) {
					const _this = this
					
					//增加機率
					this.rate = this.rate.map(function (value) {
						_this.items.forEach(function(item) {
							if (value.gradeId == item.gradeId) {
								value.count++
							}
						})

						value.myProbability = ((value.count / (_this.numberDraws * 11)) * 100).toFixed(4);
						return value
					})
				}
			}
		},
		methods: {
			getRate() {
				const _this = this

				axios.get('/api/rate').then(function (response) {
					const result = response.data
					_this.rate = result
        });
			},
			lottery() {
				const _this = this

				if (this.start) {
					return
				}

				if (this.loading) {
					return
				}

				this.loading = true
				this.items = []
				this.detail = ''
				this.isCardOpen = false
				
				axios.post('/api/lottery').then(function (response) {
					const result = response.data
					_this.items = result.data
					_this.numberDraws++
					_this.start = true
					_this.loading = false
        });
			},
			allOpen() {
				const _this = this
				this.isCardOpen = true
				this.isAllOpen = true

				this.items = this.items.map(function (value, index) {
					if (value.gradeId < 3) {
						value.flip = true
					} else {
						_this.isAllOpen = false
					}
					
					return value
				})

				if (this.isAllOpen) {
					this.start = false
				}
			},
			checkCardBg(item) {
				if (item.gradeId < 3) {
					return "background-image: url('/img/default.jpg')"
				} else {
					return "background-image: url('/img/nice.jpg');"
				}
			},
			cardClick(item) {
				this.isCardOpen = true

				if (item.gradeId < 3) {
					item.flip = !item.flip
				} else {
					lity('#inline')

					this.detail = item
					this.detail.flip = false
					this.detail.gold = false
					this.result_text = '(;ﾟдﾟ): 歐拉歐拉歐拉~~歐拉'
				}
			},
			openDetail() {
				this.detail.flip = true

				if (this.detail.gradeId == 4) {
					this.detail.gold = true
					this.result_text = '(ﾟд⊙): KO !!!!!!!!!!!!!!!!!!!!'
				} else {
					this.result_text = '(‘⊙д-): K.......ㄜ'
				}

				//檢查是不是全部已開
				let check = true

				this.items.forEach(function(item) {
					if (!item.flip) {
						check = false
					}
				})

				if (check) {
					this.start = false
				}
			},
			computedResultBanner() {
				if (this.start) {
					return ''
				}

				if (this.detail.gold) {
					return 'background-image: url(/img/gold.jpg)'
				} else {
					return 'background-image: url(/img/smile2.jpg)'
				}
			}
		}
	})
</script>

</html>
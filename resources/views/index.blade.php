<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>W</title>
	<link rel="stylesheet" href="/css/aos.css" />
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/lity.min.css">
</head>

<body>
	<div id="app">
		<div class="rate">
			機率:
			<span v-for="data in rate">@{{ data.name }}: @{{ data.probability }}%</span>
		</div>
		<div>
			<button class="btn btn-success" @click="lottery" v-if="!start">上級變身抽卡11次</button>
			<button class="btn btn-danger" @click="allOpen" v-else>全部開啟</button>
		</div>
		<div
			class="card item"
			:data-aos="!isCardOpen ? 'fade-down' : ''"
			:data-aos-delay="index * 50"
			:class="item.flip ? 'flip' : ''"
			v-for="(item, index) in items"
			v-if="items.length"
			@click="cardClick(item)"
		>
			<div class="face front" :style="checkCardBg(item)">
				<h2><small></small></h2>
			</div>
			<div class="face back" :class="'g-' + item.gradeId">
				<div class="img_content" :class="'gb-' + item.gradeId">
					<img src="/img/in.jpg" :alt="item.name" v-if="item.image == ''" />
					<img :src="item.image" :alt="item.name" v-else />
				</div>
				<div class="description">
					@{{ item.name }}
				</div>
			</div>
		</div>
		<div id="inline" class="lity-hide">
			<div class="in_content">
				<div class="in_banners" :style="detail.gold ? 'background-image: url(/img/gold.jpg)' : ''" style="box-shadow: 6px 6px 9px black;"></div>
				<div class="card item" v-if="detail != ''" :class="detail.flip ? 'flip' : ''" @click="openDetail()" style="position: relative;left: 27%;">
					<div class="face front" style="background-image: url('/img/nice.jpg')">
						<h2><small></small></h2>
					</div>
					<div class="face back" :class="'g-' + detail.gradeId">
						<div class="img_content" :class="'gb-' + detail.gradeId">
							<img src="/img/in.jpg" :alt="detail.name" v-if="detail.image == ''" />
							<img :src="detail.image" :alt="detail.name" v-else />
						</div>
						<div class="description">
							@{{ detail.name }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--統計-->
		<p>已抽次數: @{{ numberDraws }}</p>
		<p>花費鑽石: @{{ 1200 * numberDraws }}</p>
		<table class="table table-dark">
			<thead>
				<tr>
					<th></th>
					<th>次數</th>
					<th>抽到機率</th>
					<th>官方機率</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="data in rate">
					<td>@{{ data.name }}</td>
					<td>@{{ data.count }}</td>
					<td>@{{ data.myProbability }}%</td>
					<td>@{{ data.probability }}%</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
<script src="/js/jquery.js"></script>
<script src="/js/vue.min.js"></script>
<script src="/js/axios.min.js"></script>
<script src="/js/aos.js"></script>
<script src="/js/lity.min.js"></script>
<script>
	new Vue({
		el: '#app',
		data: {
			flip: false,
			isCardOpen: false,
			items: [],
			detail: '',
			rate: [],
			start: false,
			numberDraws: 0,
		},
		mounted() {
			AOS.init();
			this.getRate()
		},
		watch: {
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

				this.items = []
				this.detail = ''
				this.isCardOpen = false
				this.start = true

				axios.post('/api/lottery').then(function (response) {
					const result = response.data
					_this.items = result.data
					_this.numberDraws++
        });
			},
			allOpen() {
				this.isCardOpen = true
				let isAllOpen = true

				this.items = this.items.map(function (value, index) {
					if (value.gradeId < 3) {
						value.flip = true
					} else {
						isAllOpen = false
					}
					
					return value
				})

				if (isAllOpen) {
					this.start = false
				}
			},
			checkCardBg(item) {
				if (item.gradeId < 3) {
					return "background-image: url('/img/default.jpg')"
				} else {
					return "background-image: url('/img/nice.jpg')"
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
				}
			},
			openDetail() {
				this.detail.flip = true
				this.start = false

				if (this.detail.gradeId == 4) {
					this.detail.gold = true
				}
			}
		}
	})
</script>

</html>
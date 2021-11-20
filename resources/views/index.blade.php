<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="first">
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <div class="container-xl">
            <div class="bg-light border rounded-3 p-2 p-sm-4 author__info" v-if="items.length == 0">
              <div class="row">
                <div class="col-12 col-sm-3 mb-3">
                  <div class="flex-shrink-0">
                    <img src="/img/gyman.jpg" alt="94i抽 - 天堂W模擬抽卡" />
                  </div>
                </div>
                <div class="col-12 col-sm-9">
                  <div class="flex-grow-1 ms-2">
                    <h5 class="mt-0">GYMAN</h5>
                    <p>
                      小朋友們, 這遊戲很可怕的, 錢不好賺, 不要學網路上的叔叔們花大錢抽卡<br />
                      主要想讓大家認識一下 這個機率有多可怕<br />
                      先來這抽抽看, 試試臉黑不黑( ^.＜ )<br />
                      抽完之後告訴我, <span class="text-danger" style="font-size: 20px;">你還想抽卡嗎???</span>
                    </p>
                    @if (!is_null($blackToday))
                    <div class="alert alert-dark border" role="alert">
                      今日黑臉兄: <span class="font-weight-bold text-nowrap" style="font-size: 24px;">{{ $blackName->nickname ?? '' }}</span>
                      <br>
                      次數: {{ $blackToday->count }}, 紅變: {{ $blackToday->g_4 }}, 機率: {{ number_format(($blackToday->g_4 / ($blackToday->count * 11)) * 100, 4); }}
                    </div>
                    @endif
                    @if (!is_null($whiteToday))
                    <div class="alert alert-light border" role="alert">
                      今日小白臉: <span class="font-weight-bold text-nowrap" style="font-size: 24px;">{{ $whiteName->nickname ?? '' }}</span>
                      <br>
                      次數: {{ $whiteToday->count }}, 紅變: {{ $whiteToday->g_4 }}, 機率: {{ number_format(($whiteToday->g_4 / ($whiteToday->count * 11)) * 100, 4); }}
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-4">
              <div
                class="col-3 col-sm-2"
                v-for="(item, index) in items"
                v-if="items.length"
                :data-aos="!isCardOpen ? 'fade-down' : ''"
                :data-aos-delay="index * 50"
                @click="cardClick(item)"
              >
                <div class="card text-white bg-dark mb-1 mb-lg-3" :class="[item.flip ? 'open' : '', item.gradeId >= 3 ? 'surprise' : '']">
                  <div class="face front" :class="item.gradeId > 2 ? 'surprise' : ''" :style="checkCardBg(item)"></div>
                  <div class="face back">
                    <div class="card-img-top" :style="'background-image: url(' + item.image + ');'" v-if="item.image != ''"></div>
                    <div class="card-img-top" style="background-image: url(/img/in{{ $type }}.jpg?v=1);" v-else></div>
                    <div class="card-body">
                      <p class="card-text">
                        <span class="text-secondary" v-if="item.gradeId == 1">@{{ item.name }}</span>
                        <span class="text-success" v-if="item.gradeId == 2">@{{ item.name }}</span>
                        <span class="text-primary" v-if="item.gradeId == 3">@{{ item.name }}</span>
                        <span class="text-danger" v-if="item.gradeId == 4">@{{ item.name }}</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="col">
                <div class="table-border mb-2">
                  <table class="table">
                    <tr>
                      <td></td>
                      <td :class="data.color" v-for="data in rate">
                        @{{ data.name }}
                      </td>
                    </tr>
                    <tr>
                      <td>總數
                        <span v-if="user != ''">(當日)</span>
                      </td>
                      <td v-for="data in rate">@{{ data.count }}</td>
                    </tr>
                    <tr>
                      <td>抽到機率</td>
                      <td v-for="data in rate">@{{ data.myProbability }}%</td>
                    </tr>
                    <tr>
                      <td>官方機率</td>
                      <td v-for="data in rate">@{{ data.probability }}%</td>
                    </tr>
                  </table>
                </div>
                <div role="alert" class="alert alert-warning">
                  <div class="rate">
                    *提示：本模擬器僅供娛樂，祝大家在遊戲上真的牙起來！*
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
        <footer id="footer" class="bg-light">
          <div class="container-xl">
            <div class="row">
              <div class="col-12 col-sm-6 p-2 order-sm-2">
                <div class="d-grid h-100">
                  <button type="button" class="btn btn-primary shadow-lg rounded h-100" @click="lottery" v-if="!start" :disabled="loading">
                    @if(!$type)
                    上級變身抽卡11次
                    @else
                    上級娃娃抽卡11次
                    @endif
                  </button>
                  <button type="button" class="btn btn-danger  shadow-lg rounded h-100" @click="allOpen" v-else :disabled="loading">
                    <span v-if="isAllOpen">全部開啟٩(^ᴗ^)۶</span>
                    <span v-else>牙起來牙起來!!</span>
                  </button>
                </div>
              </div>
              <div class="col-12 col-sm-6 p-sm-2 order-sm-0">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">已抽次數: <span>@{{ numberDraws }}</span></li>
                  <li class="list-group-item">花費鑽石: <span>@{{ 1200 * numberDraws }}</span> = 台幣 <span>@{{ 750 * numberDraws }}</span></li>
                  <li class="list-group-item"><span v-for="data in rate">@{{ data.name }}: @{{ data.count }}</span></li>
                </ul>
              </div>
              <div class="col-12 order-sm-2">
                @include('layouts.memo')
              </div>
            </div>
          </div>
        </footer>
        <div class="modal" id="red-modal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog" :class="detail.flip ? 'card-open' : ''">
            <div class="modal-content">
              <div class="card-show" v-show="detail != '' && detail.flip">
                <span class="text-card-name text-secondary" v-if="detail.gradeId == 1">@{{ detail.name }}</span>
                <span class="text-card-name text-success" v-if="detail.gradeId == 2">@{{ detail.name }}</span>
                <span class="text-card-name text-primary" v-if="detail.gradeId == 3">@{{ detail.name }}</span>
                <span class="text-card-name text-danger" v-if="detail.gradeId == 4">@{{ detail.name }}</span>
                <div class="img" :class="detail.gradeId == 4 ? 'surprise' : ''">
                  <div class="top">
                    <img :src="detail.image" :alt="detail.name" v-if="detail.image != ''"/>
                    <img src="/img/in{{ $type }}.jpg?v=1" :alt="detail.name" v-else/>
                  </div>
                  <div class="bottom">
                    <img src="/img/cb.png">
                  </div>
                </div>
                <span class="text-theme">點擊螢幕關閉</span>
              </div>
            </div>
            <video muted playsinline id="video" @ended="videoFinish" v-show="detail != ''">
              <source :src="detail.gradeId == 4 ? '/mp4/g-teeth.mp4' : '/mp4/n-teeth.mp4'" type="video/mp4" />
            </video>
          </div>
        </div>
      </div>
    </div>
    <script>
      new Vue({
        el: '#content',
        data: {
          flip: false,
          loading: false,
          userDataLoading: false,
          isCardOpen: false,
          items: [],
          detail: '',
          rate: [],
          start: false,
          isAllOpen: true,
          numberDraws: 0,
          resultText: '',
          psMemo: '',
          user: ''
        },
        mounted() {
          AOS.init();
          this.getRate()
          this.userData()
          $('#red-modal').on("hidden.bs.modal", this.videoFinish)
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
          videoFinish() {
            //img show
            this.detail.flip = true

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
          getRate() {
            const _this = this

            axios.get('/api/rate?type={{ $type }}').then(function (response) {
              const result = response.data
              _this.rate = result.data
              _this.numberDraws = result.count
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

            axios.post('/api/lottery?type={{ $type }}').then(function (response) {
              const result = response.data
              _this.items = result.data
              _this.numberDraws++
              _this.start = true
              _this.loading = false
            })
          },
          userData() {
            const _this = this
            this.user = ''
            this.userDataLoading = true

            axios.post('/api/user').then(function (response) {
              _this.user = response.data
              _this.userDataLoading = false
            }).catch((error)=>{
              _this.userDataLoading = false
            })
          },
          allOpen() {
            const _this = this
            this.isCardOpen = true
            this.isAllOpen = true
            let checkAllOpen = true

            this.items = this.items.map(function (value, index) {
              if (value.gradeId < 3) {
                value.flip = true
              } else {
                _this.isAllOpen = false
              }

              if (!value.flip) {
                checkAllOpen = false
              }

              return value
            })

            if (this.isAllOpen || checkAllOpen) {
              this.start = false
            }
          },
          checkCardBg(item) {
            if (item.gradeId < 3) {
              return "background-image: url('/img/default{{ $type }}.jpg')"
            } else {
              return "background-image: url('/img/nice{{ $type }}.jpg');"
            }
          },
          cardClick(item) {
            if (this.detail != '' && this.detail.t_id == item.t_id) {
              item.flip = true
              return
            }

            this.detail = ''

            if (item.gradeId >= 3) {
                this.detail = item
                this.detail.flip = false
                this.detail.gold = false
                this.resultText = '(;ﾟдﾟ): 歐拉歐拉歐拉~~歐拉'

                $('#red-modal').modal('toggle')

                //play
                const vid = document.getElementById("video")
                vid.currentTime = 0;
                vid.src = this.detail.gradeId == 4 ? '/mp4/g-teeth.mp4' : '/mp4/n-teeth.mp4';

                setTimeout(() => {
                  vid.play()
                }, 500)
            } else {
              this.isCardOpen = true
              item.flip = true
            }
          },
          openDetail() {
            this.detail.flip = true

            if (this.detail.gradeId == 4) {
              this.detail.gold = true
              this.resultText = '(ﾟд⊙): KO !!!!!!!!!!!!!!!!!!!!'
            } else {
              this.resultText = '(‘⊙д-): K.......ㄜ'
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
          }
        }
      })
    </script>
  </body>
</html>
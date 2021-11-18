<!DOCTYPE html>
<html>
  @include('layouts.head')
  <style>
      .swiper {
        width: 100%;
        height: 100%;
      }

      .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
      }

      .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    </style>
  <body>
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <h2 class="text-white">我的卡池</h2>
          <div class="card-detail" v-if="detail != ''">
              <div class="row">
                <div class="col">
                  <h2 class="text-white">@{{ detail.transform.name }}</h2>
                  <img class="card-img-top" :src="detail.transform.image" alt="" v-if="detail.transform.image != ''">
                  <img class="card-img-top" src="/img/in.jpg" alt="" v-else>
                </div>
                <div class="col text-white">
                  <P>武器類型: @{{ detail.transform.weaponTypeList_string }}</P>
                  <P>數值: @{{ detail.transform.buffBonusList_string }}</P>
                </div>
              </div>
          </div>
          <div class="swiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide"  v-for="card in cards" @click="detail = card">
                <div class="card" style="width: 18rem;">
                  數量: @{{ card.count }}
                  <img class="card-img-top" :src="card.transform.image" alt="" v-if="card.transform.image != ''">
                  <img class="card-img-top" src="/img/in.jpg" alt="" v-else>
                  <div class="card-body">
                    <p class="card-text">
                      <p class="card-text">
                        <span :class="card.color">@{{ card.transform.name }}</span>
                      </p>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
        <footer id="footer" class="bg-light">
          <div class="container-xl">
            <div class="row">
              <div class="col-12 order-sm-2">
                @include('layouts.memo')
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script>
      new Vue({
        el: '#content',
        data: {
          loading: false,
          cards: [],
          detail: '',
        },
        mounted() {
          AOS.init()
          this.getCards()
        },
        methods: {
          getCards() {
            const _this = this

            axios.get('/api/cards').then(function (response) {
              _this.cards = response.data

              if (_this.cards.length) {
                _this.detail = _this.cards[0]
              }

              //start swiper
              setTimeout(() => {
                _this.startSwiper()
              }, 500)
            });
          },
          startSwiper() {
            new Swiper(".swiper", {
              slidesPerView: 1,
              spaceBetween: 10,
              breakpoints: {
                640: {
                  slidesPerView: 2,
                  spaceBetween: 20,
                },
                768: {
                  slidesPerView: 4,
                  spaceBetween: 40,
                },
                1024: {
                  slidesPerView: 5,
                  spaceBetween: 50,
                },
              },
            })
          }
        }
      })
    </script>
  </body>
</html>
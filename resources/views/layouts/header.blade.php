@php
  $type = Request::input('type', 0);
  $name = Route::currentRouteName();
@endphp
<header id="header" v-cloak>
  <div class="container-xl">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="text-white text-decoration-none d-none d-sm-block">
        <h5 class="mb-0">94i抽 - 天堂W模擬抽卡</h5>
      </a>

      <ul class="nav">
        <li><a href="/" class="nav-link px-2 @if($name == 'index' && $type == 0) text-warning @endif text-secondary">抽變身</a></li>
        <li><a href="/?type=1" class="nav-link px-2 @if($name == 'index' && $type == 1) text-warning @endif text-secondary">抽魔法娃娃</a></li>
        <li><a href="/rank" class="nav-link px-2 @if($name == 'rank') text-warning @endif text-secondary">排行榜</a></li>
      </ul>

      <div class="text-end">
        <div v-if="user == '' && !userDataLoading">
          <button type="button" class="btn btn-sm btn-outline-light me-2" @click="openLogin(1)">登入</button>
          <button type="button" class="btn btn-sm btn-warning" @click="openLogin(0)">註冊</button>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" v-if="user != ''">
            <span>Hi ~ @{{ user.nickname }}</span>
          </div>
          <div class="dropdown" v-if="user != '' && !userDataLoading">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="user" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="/img/gyman.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="user">
              <li><a class="dropdown-item" href="/history">我的戰績</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#" @click="logout">登出</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="modal" id="lr-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">@{{ !isLogin ? '註冊' : '登入'}}</h5>
          <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" @click="closeLRModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form>
          <div class="modal-body">
            <div class="text-center">
              <div class="login" v-if="isLogin">
                <div class="form-group">
                  <input type="text" name="account" class="form-control" placeholder="請輸入帳號" v-model="loginData.account">
                </div>
                <div class="form-group mt-1">
                  <input type="password" name="password" class="form-control" placeholder="請輸入密碼" v-model="loginData.password">
                </div>
              </div>
              <div class="sign-in" v-else>
                <div class="form-group">
                  <input type="text" class="form-control" name="account" placeholder="請輸入帳號" v-model="signInData.account">
                  <small class="form-text text-muted text-left">限定字數為 2~11</small>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="nickname" placeholder="請輸入暱稱" v-model="signInData.nickname">
                  <small class="form-text text-muted text-left">限定字數為 2~11</small>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="請輸入密碼" v-model="signInData.password">
                  <small class="form-text text-muted text-left">限定字數為 2~11</small>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control"  name="password_confirmation" placeholder="請重覆輸入密碼" v-model="signInData.password_confirmation">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeLRModal()">關閉</button>
            <button type="button" class="btn btn-primary" @click="doLoginOrSignIn">送出</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row text-center" v-if="historyRate.length > 0">
            <table class="table table-dark">
              <tr>
                <td></td>
                <td :class="data.color" v-for="data in historyRate">
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
            <div role="alert" class="alert alert-warning">
              <div class="rate">
                *提示：本模擬器僅供娛樂，祝大家在遊戲上真的牙起來！*
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</header>
<script>
  new Vue({
    el: '#header',
    data: {
      userDataLoading: false,
      isLogin: false,
      detail: '',
      loginData: {
        account: '',
        password: '',
      },
      signInData: {
        account: '',
        nickname: '',
        password: '',
        password_confirmation: '',
      },
      isLogin: true,
      user: '',
      historyRate: [],
    },
    mounted() {
      this.userData()
    },
    methods: {
      logout() {
        const _this = this

        axios.post('/api/logout').then(function (response) {
          _this.userData()
        }).catch((error)=>{
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
      closeLRModal() {
        $('#lr-modal').modal('toggle')
      },
      doLoginOrSignIn() {
        let url = ''
        let postData = []
        const _this = this

        if (this.isLogin) {
          postData = this.loginData
          url = '/api/login'
        } else {
          postData = this.signInData
          url = '/api/signIn'

          if (postData.account == '') {
            alert('暱稱未輸入')
            return
          }

          if (postData.password != postData.password_confirmation) {
            alert('密碼重覆確認錯誤')
            return
          }
        }

        if (postData.account == '') {
          alert('帳號未輸入')
          return
        }

        if (postData.password == '') {
          alert('密碼未輸入')
          return
        }

        axios.post(url, postData).then(function (response) {
          const result = response.data
          alert('註冊登入成功!')
          location.reload()
          $('#lr-modal').modal('toggle')
        }).catch((error)=>{
          alert('失敗: ' +  error.response.data.message)
        })
      },
      openLogin(type) {
        this.isLogin = type

        //清空
        this.loginData = {
          account: '',
          password: '',
        },
        this.signInData = {
          account: '',
          nickname: '',
          password: '',
          password_confirmation: '',
        },

        $('#lr-modal').modal('toggle')
      },
    }
  })
</script>
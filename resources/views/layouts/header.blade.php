<header id="header" class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <h5>94i抽 - 天堂W模擬抽卡</h5>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 text-warning">抽變身</a></li>
        <li><a href="#" class="nav-link px-2 text-white">抽魔法娃娃</a></li>
        <li><a href="#" class="nav-link px-2 text-white">排行榜</a></li>
      </ul>
      <div class="text-end" v-if="user == '' && !userDataLoading">
        <button type="button" class="btn btn-outline-light me-2" @click="openLogin(1)">登入</button>
        <button type="button" class="btn btn-warning" @click="openLogin(0)">註冊</button>
      </div>
      <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" v-if="user != ''">
        <span>Hi ~ @{{ user.nickname }}</span>
      </div>
      <div class="dropdown text-end" v-if="user != '' && !userDataLoading">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="user" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="/img/gyman.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small" aria-labelledby="user">
          <li><a class="dropdown-item" href="#">抽卡紀錄</a></li>
          <li><a class="dropdown-item" href="#">我的卡池</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#" @click="logout">登出</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="modal" id="lr-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">@{{ !isLogin ? '註冊' : '登入'}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="login" v-if="isLogin">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="請輸入帳號" v-model="loginData.account">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="請輸入密碼" v-model="loginData.password">
              </div>
            </div>
            <div class="sign-in" v-else>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="請輸入帳號" v-model="signInData.account">
                <small class="form-text text-muted text-left">限定字數為 2~11</small>
              </div>
              <div class="form-group">
                <input type="account" class="form-control" placeholder="請輸入暱稱" v-model="signInData.nickname">
                <small class="form-text text-muted text-left">限定字數為 2~11</small>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="請輸入密碼" v-model="signInData.password">
                <small class="form-text text-muted text-left">限定字數為 2~11</small>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="請重覆輸入密碼" v-model="signInData.password_confirmation">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="doLoginOrSignIn">送出</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">關閉</button>
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
      user: ''
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
      closeModal() {
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
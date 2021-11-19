<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="page">
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <div class="container-xl">
            <h2 class="text-left text-white my-4">{{ $user->account }} 的戰績</h2>
            @if($user)
            <!-- <ul class="list-group mb-2 text-center">
              <li class="list-group-item">總抽卡次數: {{ $user->total_count }}</li>
              <li class="list-group-item"><span class="text-danger">英雄</span>總數: {{ $user->total_c_4 }} / 抽到機率: {{ $user->total_p_4 }}</li>
              <li class="list-group-item"><span class="text-primary">稀有</span>總數: {{ $user->total_c_3 }} / 抽到機率: {{ $user->total_p_3 }}</li>
              <li class="list-group-item"><span class="text-success">高級</span>總數: {{ $user->total_c_2 }} / 抽到機率: {{ $user->total_p_2 }}</li>
              <li class="list-group-item"><span class="text-secondary">一般</span>總數: {{ $user->total_c_1 }} / 抽到機率: {{ $user->total_p_1 }}</li>
            </ul> -->
            <div class="row">
              <div class="col mb-2">
                <div class="table-border">
                  <table class="table table-striped table-dark">
                    <tr>
                      <td colspan="5" class="text-center">抽卡次數: {{ $user->total_count }}</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><span class="text-danger">英雄</span></td>
                      <td><span class="text-primary">稀有</span></td>
                      <td><span class="text-success">高級</span></td>
                      <td><span class="text-secondary">一般</span></td>
                    </tr>
                    <tr>
                      <td>總數</td>
                      <td>{{ $user->total_c_4 }}</td>
                      <td>{{ $user->total_c_3 }}</td>
                      <td>{{ $user->total_c_2 }}</td>
                      <td>{{ $user->total_c_1 }}</td>
                    </tr>
                    <tr>
                      <td>官方機率</td>
                      <td>{{ $user->total_p_4 }}</td>
                      <td>{{ $user->total_p_3 }}</td>
                      <td>{{ $user->total_p_2 }}</td>
                      <td>{{ $user->total_p_1 }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            @endif
            <div class="row">
              @foreach($history as $date => $data)
              <div class="col">
                <div class="table-border">
                  <table class="table table-striped table-dark">
                    <tr>
                      <th colspan="5" class="bg-primary text-white text-center">{{ $date }}</th>
                    </tr>
                    <tr>
                      <td></td>
                      @foreach($data as $detail)
                      <td class="{{ $detail['color'] }}">
                        {{ $detail['name'] }}
                      </td>
                      @endforeach
                    </tr>
                    <tr>
                      <td>總數</td>
                      @foreach($data as $detail)
                      <td>
                        {{ $detail['count'] }}
                      </td>
                      @endforeach
                    </tr>
                    <!-- <tr>
                      <td>抽到機率</td>
                      @foreach($data as $detail)
                      <td>
                        {{ $detail['myProbability'] }}
                      </td>
                      @endforeach
                    </tr> -->
                    <tr>
                      <td>官方機率</td>
                      @foreach($data as $detail)
                      <td>
                        {{ $detail['probability'] }}
                      </td>
                      @endforeach
                    </tr>
                  </table>
                </div>
              </div>
              @endforeach
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
  </body>
</html>
<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="page">
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <div class="container-xl">
            <h2 class="text-center text-white my-4">排行榜</h2>
            <p class="text-center text-white my-4">(需註冊及抽50次以上)</p>
            <div class="row">
              <div class="col">
                <h5 class="text-center text-white">臉黑大將軍</h5>
                <table class="table table-striped table-dark table-border">
                  <tr>
                    <th scope="col" style="width: 2rem;" class="text-white bg-primary">Rank</th>
                    <th class="text-white bg-primary">暱稱</th>
                    <th class="text-white bg-primary">總抽</th>
                    <th class="text-white bg-primary">台幣</th>
                    <th class="text-white bg-primary">紅變</th>
                    <th class="text-white bg-primary">機率</th>
                  </tr>
                  @foreach($blackData as $key => $data)
                  <tr>
                    <td>
                      @if($key == 0)
                      🥇
                      @elseif($key == 1)
                      🥈
                      @elseif($key == 2)
                      🥉
                      @else
                      {{ $key + 1 }}
                      @endif
                    </td>
                    <td>{{ $data['nickname'] }}</td>
                    <td>{{ $data['total_count'] }}</td>
                    <td>{{ 750 * $data['total_count'] }}</td>
                    <td>{{ round($data['total_c_4']) }}</td>
                    <td>{{ $data['total_p_4'] }}%</td>
                  </tr>
                  @endforeach
                </table>
              </div>
              <div class="col">
                <h5 class="text-center text-white">歐皇降臨</h5>
                <table class="table table-striped table-dark table-border">
                  <tr>
                    <th scope="col" style="width: 2rem;" class="text-white bg-primary">Rank</th>
                    <th class="text-white bg-primary">暱稱</th>
                    <th class="text-white bg-primary">次數</th>
                    <th class="text-white bg-primary">台幣</th>
                    <th class="text-white bg-primary">紅變</th>
                    <th class="text-white bg-primary">機率</th>
                  </tr>
                  @foreach($whiteData as $key => $data)
                  <tr>
                    <td>
                      @if($key == 0)
                      🥇
                      @elseif($key == 1)
                      🥈
                      @elseif($key == 2)
                      🥉
                      @else
                      {{ $key + 1 }}
                      @endif
                    </td>
                    <td>{{ $data['nickname'] }}</td>
                    <td>{{ $data['total_count'] }}</td>
                    <td>{{ 750 * $data['total_count'] }}</td>
                    <td>{{ round($data['total_c_4']) }}</td>
                    <td>{{ $data['total_p_4'] }}%</td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </main>
        <footer id="footer" class="bg-light" style="height:auto">
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
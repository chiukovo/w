<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="page">
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <div class="container-xl">
            <h2 class="text-center my-4">排行榜</h2>
            <div class="row">
              <div class="col">
                <h5 class="text-center">臉黑大將軍</h5>
                <table class="table table-striped table-border">
                  <tr class="bg-primary">
                    <th scope="col" style="width: 2rem;" class="text-white">Rank</th>
                    <th class="text-white">暱稱</th>
                    <th class="text-white">總抽次數</th>
                    <th class="text-white">紅變數量</th>
                    <th class="text-white">抽到機率</th>
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
                    <td>{{ $data['total_c_4'] }}</td>
                    <td>{{ $data['total_p_4'] }}%</td>
                  </tr>
                  @endforeach
                </table>
              </div>
              <div class="col">
                <h5 class="text-center">歐皇降臨</h5>
                <table class="table table-striped table-border">
                  <tr class="bg-primary">
                    <th scope="col" style="width: 2rem;" class="text-white">Rank</th>
                    <th class="text-white">暱稱</th>
                    <th class="text-white">總抽次數</th>
                    <th class="text-white">紅變數量</th>
                    <th class="text-white">抽到機率</th>
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
                    <td>{{ $data['total_c_4'] }}</td>
                    <td>{{ $data['total_p_4'] }}%</td>
                  </tr>
                  @endforeach
                </table>
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
  </body>
</html>
<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="page">
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <div class="container-xl">
            <h2 class="text-left my-4">排行榜</h2>
            <div class="row">
              <div class="col">
                <h3>臉黑大將軍</h3>
                <table class="table table-borderless">
                  <tr>
                    <th scope="col" style="width: 2rem;">Rank</th>
                    <th>暱稱</th>
                    <th>總抽次數</th>
                    <th>紅變數量</th>
                    <th>抽到機率</th>
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
                <h3>歐皇降臨</h3>
                <table class="table table-borderless">
                  <tr>
                    <th scope="col" style="width: 2rem;">Rank</th>
                    <th>暱稱</th>
                    <th>總抽次數</th>
                    <th>紅變數量</th>
                    <th>抽到機率</th>
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
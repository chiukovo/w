<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="page">
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <div class="container-xl">
            <h2 class="text-left my-4">{{ $account }} 的戰績</h2>
            @if(!empty($sumData))
            <ul class="list-group m-2">
              <li class="list-group-item">總抽卡次數: {{ $sumData['count'] ?? 0 }}</li>
              <li class="list-group-item"><span class="text-danger">英雄</span>總數: {{ $sumData['g_4'] ?? 0 }} 抽到機率: {{ $sumData['p_4'] }}</li>
              <li class="list-group-item"><span class="text-primary">稀有</span>總數: {{ $sumData['g_3'] ?? 0 }} 抽到機率: {{ $sumData['p_3'] }}</li>
              <li class="list-group-item"><span class="text-success">高級</span>總數: {{ $sumData['g_2'] ?? 0 }} 抽到機率: {{ $sumData['p_2'] }}</li>
              <li class="list-group-item"><span class="text-secondary">一般</span>總數: {{ $sumData['g_1'] ?? 0 }} 抽到機率: {{ $sumData['p_1'] }}</li>
            </ul>
            @endif
            <div>
              @foreach($history as $date => $data)
              <div class="row">
                <div class="col">
                  <div class="table-border">
                    <table class="table table-striped">
                      <tr>
                        <th colspan="5" class="bg-primary text-white">{{ $date }}</th>
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
                      <tr>
                        <td>抽到機率</td>
                        @foreach($data as $detail)
                        <td>
                          {{ $detail['myProbability'] }}
                        </td>
                        @endforeach
                      </tr>
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
              </div>
              @endforeach
            </div>
          </div>
        </main>
        <footer id="footer" class="bg-light">
          <div class="container-xl">
            <div class="row">
              <div class="col-12 order-sm-2">
                <p class="memo">
                  本站無任何營利 如有任何侵權 請來信告知 <a href="mailto:qcworkman@gmail.com">qcworkman@gmail.com</a><br />
                  copyright © 94ichouo All rights reserved.
                </p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </body>
</html>
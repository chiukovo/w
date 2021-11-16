<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body>
    <div id="app" v-cloak>
      @include('layouts.header')
      <div id="content">
        <main id="main">
          <h2 class="text-white">抽卡紀錄</h2>
          <div class="container-xl">
            @foreach($history as $date => $data)
            <div class="row text-center">
              <h2 class="text-white">{{ $date }}</h2>
              <table class="table table-dark">
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
            @endforeach
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
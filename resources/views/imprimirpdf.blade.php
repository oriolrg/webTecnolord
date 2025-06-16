<html>
<head>
  <style>
    body{
      font-family: sans-serif;
    }
    @page {
      margin: 160px 50px;
    }
    header { position: fixed;
      left: 0px;
      top: -160px;
      right: 0px;
      height: 100px;
      background-color: #ddd;
      text-align: center;
    }
    header h1{
      margin: 10px 0;
    }
    header h2{
      margin: 0 0 10px 0;
    }
    footer {
      position: fixed;
      left: 0px;
      bottom: -50px;
      right: 0px;
      height: 40px;
      border-bottom: 2px solid #ddd;
    }
    footer .page:after {
      content: counter(page);
    }
    footer table {
      width: 100%;
    }
    footer p {
      text-align: right;
    }
    footer .izq {
      text-align: left;
    }
  </style>
<body>

    @php ($repeat = '')
    @foreach($data as $key => $error)
        @if ($repeat != $error[1])
            <header>
                @php ($repeat = $error[1])
                <h1>{{$error[1]}}</h1>
            </header>
        @endif
        <footer>
            <table>
            <tr>
                <td>
                    <p class="izq">
                    Opos Oriol Riu
                    </p>
                </td>
                <td>
                <p class="page">
                    Pàgina
                </p>
                </td>
            </tr>
            </table>
        </footer>
        <div id="content">
            <h3>
                {{$error[0]}}
            </h3>
            <p  style='text-indent: 1em'>
                {{$error[2]->answer}}
            </p>
            <p style="page-break-before: always;"></p>
            
        </div>
    @endforeach
    <p style="page-break-before: always;"></p>
</body>
</html>
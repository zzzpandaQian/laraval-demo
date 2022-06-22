<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      word-wrap: none;
      word-break: break-all;
    }
    .table th,
    .table td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #222;
    }
    .table thead th {
      vertical-align: bottom;
      border-bottom: 1px solid #222;
    }
    .table tbody + tbody {
      border-top: 2px solid #222;
    }
    .table-bordered th,
    .table-bordered td {
      border: 1px solid #222;
    }
    .tr_basic td{
      text-align: center;
    }
    .tr_wrap{
      padding: 0 0.75rem;
      border-width: 0 1px 1px;
      border-style: solid;
      border-color: #222;
    }
    .text-center{
      text-align: center;
    }
    .bold{
      font-weight: bold;
      color: #222;
    }
    img{
      max-width: 100%;
      max-height: 200px;
      margin-right:10px;
      margin-bottom:10px;
      width: auto;
      height: auto;
    }
  </style>
</head>
<body>
  <h1>FAQ</h1>
@foreach ($collection as $item)

  <table class="table table-bordered">
    <tbody>
      <tr>
        <tr>
          <td>标题：</td>
          <td>{{ $item->title }}</td>
          <td>时间：</td>
          <td>{{ $item->created_at }}</td>
        </tr>
    </tbody>
  </table>
  <br/>
  <br/>
@endforeach

</body>
</html>

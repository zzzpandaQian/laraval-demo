{!! Form::open(['method' => 'GET','route' => ['news.search'],'style'=>'display:inline']) !!}
  <div class="form-group">
    <input type="text" class="form-control" name="keyword" value="{{ isset($_GET['keyword']) ? $_GET['keyword'] : '' }} " placeholder="关键词">
  </div>
  <button type="submit" class="btn btn-default">搜索</button> &nbsp;
{!! Form::close() !!}
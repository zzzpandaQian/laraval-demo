<div class="box box-info">
  <div class="box-header with-border">
      <h3 class="box-title">导入</h3>

      <div class="box-tools">
          <div class="btn-group pull-right" style="margin-right: 5px">
              <a href="{{ asset('download/news.xlsx') }}" class="btn btn-sm btn-info" target="_blank">
                <i class="fa fa-download"></i>下载模板
              </a>

              <a href="{{ route('news.index') }}" class="btn btn-sm btn-default" title="列表">
                  <i class="fa fa-list"></i><span class="hidden-xs">&nbsp;列表</span>
              </a>
          </div>
      </div>
  </div>
  <!-- /.box-header -->

  <!-- form start -->
  <form action="{{ route('news.import') }}" method="post" enctype="multipart/form-data" class="form-horizontal" >
      <div class="box-body">
          @if (count($errors) > 0)
          <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
              @endforeach
          </div>
          @endif

          <div class="form-group">
            <label for="news_category" class="col-sm-2  control-label">分类名</label>
            <div class="col-sm-8">
              <select name="news_category_id" class="form-control" id="exampleFormControlSelect1" required>
                <option value="">--请选择--</option>
                @foreach ($data as $key => $item)
                  @if(isset($news_category_id) && $news_category_id != 0 && $key == $news_category_id)
                    <option value="{{$key}}" selected="selected">{{$item}}</option>
                  @else
                    <option value="{{$key}}">{{$item}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
              <label for="keyword" class="col-sm-2  control-label">上传文件</label>
              <div class="col-sm-8">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-unlink"></i></span>
                      <input type="file" id="keyword" required name="excel_file" class="form-control keyword"
                      accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv">
                  </div>
              </div>
          </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
          {{ csrf_field() }}
          <div class="col-md-2"></div>
          <div class="col-md-8">
              <div class="btn-group pull-right">
                  <button type="submit" class="btn btn-primary">提交</button>
              </div>
          </div>
      </div>
      {{-- <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}" class="_method"> --}}
      <!-- /.box-footer -->
  </form>
</div>

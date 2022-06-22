<form action="{{ isset($item) ? route('templates.update', $item->id) : route('templates.store') }}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">

  <div class="box-body">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form-group">
          <label for="template_id" class="col-sm-1 control-label">模板id</label>
          <div class="col-sm-11">
            {!! Form::text('template_id', old('template_id', isset($item) ? $item->template_id : ''), array('id'=>'template_id','class' => 'form-control')) !!}
          </div>
        </div>

        <div class="form-group">
          <label for="description" class="col-sm-1  control-label">状态</label>
          <div class="col-sm-8">
            @if (isset($item->status) && $item->status == 1)
              <input type="radio" value="1" name="status"/>&nbsp;&nbsp;使用&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" value="0" name="status"  checked="checked"/>&nbsp;&nbsp;停用&nbsp;&nbsp;&nbsp;&nbsp;
            @else
              <input type="radio" value="1" name="status"  checked="checked"/>&nbsp;&nbsp;使用&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" value="0" name="status" />&nbsp;&nbsp;停用&nbsp;&nbsp;&nbsp;&nbsp;
            @endif
          </div>
        </div>

        <div class="box-footer">
        {{ csrf_field() }}
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">提交</button>
            </div>
          </div>
        </div>

        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}" class="_method">

      </div>
    </div>
  </div>
  <script>
  </script>

</form>
<!-- /.box-footer -->

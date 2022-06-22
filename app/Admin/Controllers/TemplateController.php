<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Template;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;

class TemplateController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('自定义模板')
            ->description('适用于需要自定义视图文件的模块')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('自定义模板')
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $template = Template::where('id', $id)->first();
        return $content
            ->header('自定义模板')
            ->description('修改')
            ->body(view('admin.templates.form', ['item' => $template]));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('自定义模板')
            ->description('新增')
            ->body(view('admin.templates.form'));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Template);

        $grid->id('Id');
        $grid->template_id('模板ID');
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-". $labelStyle ."'>" . $active[$status] . "</span>";
        });
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/2, function ($filter) {
                $filter->like('title', '标题');
                $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.active'));
            });

        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Template::findOrFail($id));

        $show->id('Id');
        $show->template_id('模板ID');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'template_id' => 'required',
        ]);

        $inputs = $request->all();


        $project = Template::create($inputs);
        $project->save();

        admin_toastr('创建成功', 'success');

        return redirect()->route('templates.index');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'template_id' => 'required',
        ]);

        $inputs = $request->all();
        unset($inputs['_token'], $inputs['_method']);

        $project = Template::where('id', $id)->update($inputs);

        admin_toastr('修改成功', 'success');

        return redirect()->route('templates.index');
    }
}

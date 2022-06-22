<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use App\Imports\UsersImport;
use Excel;
use App\Admin\Extensions\UserExporter;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', __('编号'));
        $grid->column('name', __('姓名'));
        $grid->column('email', __('邮箱'));
        $grid->column('mobile', __('手机号'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-". $labelStyle ."'>" . $active[$status] . "</span>";
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        $grid->exporter(new UserExporter());
        // 自定义导入
        $grid->tools(function ($tools) {
            $tools->append('<a href="' . route('users.import') . '" class="btn btn-sm btn-info" ><i class="glyphicon glyphicon-open"></i> 导入用户</a>');
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->column(1/2, function ($filter) {
                $filter->like('name', '名称');
                $filter->like('mobile', '手机号');
            });

            $filter->column(1/2, function ($filter) {
                $filter->like('email', '邮箱');
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('name', __('姓名'));
        $show->field('email', __('邮箱'));
        $show->field('mobile', __('电话'));
        $show->field('gender', __('性别'))->using(config('array.gender'));
        $show->field('birthdate', __('出生日期'));
        $show->field('avatar', __('头像'))->image();
        $show->field('address', __('地址'));
        $show->field('wx_nickname', __('微信昵称'));
        $show->field('status', __('状态'))->using(config('array.active'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', __('姓名'))->rules('required');
        $form->email('email', __('邮箱'));
        $form->text('mobile', __('手机号'))->rules('required');
        $form->password('password', __('密码'));
        $form->date('birthdate', __('出生日期'));
        $form->radio('gender', __('性别'))->options(config('array.gender'))->default(1);
        $form->image('avatar', __('自定义头像'))->move('user/avatar')->help("建议尺寸：200x200");
        $form->text('address', __('地址'));
        $form->radio('status', __('状态'))->options(config('array.active'))->default('1');

        $form->ignore(['password']);
        $form->saving(function (Form $form) {
            if (request('password')) {
                $form->password = bcrypt(request('password'));
            }
        });

        return $form;
    }

    /**
     * Undocumented function
     *
     * @param Content $content
     * @param Request $request
     * @return void
     */
    public function import(Content $content, Request $request)
    {
        if ($request->isMethod('post')) {
            $files     = $request->file('excel_file');                         //接收文件
            if (!isset($files)) {
                admin_error('请选择文件');
                return redirect(route('users.import'));
            }
            $entension = $files -> getClientOriginalExtension();               //获得文件后缀名
            $tabl_name = date('YmdHis').mt_rand(100, 999);
            $newName   = $tabl_name.'.'.$entension;                            //文件名设置
            $paths     = $request->file('excel_file')->storeAs('', $newName);  //文件上传到项目
            $import    = new UsersImport;
            $reader    = Excel::import($import, $paths);                       //导入到数据库

            admin_success('数据已导入'.$import->getSuccessRows().'行，未导入'.$import->getFailedRows().'行');
            return redirect(route('users.index'));
        }

        return $content
            ->header('用户')
            ->description('导入')
            ->body(view('admin.users.import'));
    }
}

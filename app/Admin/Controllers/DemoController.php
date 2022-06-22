<?php

namespace App\Admin\Controllers;

use App\Models\Demo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Encore\Admin\Controllers\AdminController;

class DemoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Demo';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Demo());

        $grid->column('id', __('ID'));
        $grid->column('title', __('标题'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->column(1/2, function ($filter) {
                $filter->like('title', '标题');
                $filter->in('select', '单选')->select([1 => 'foo', 2 => 'bar', 3 => 'val']);
                $filter->in('multipleSelect', '多选')->multipleSelect([1 => 'foo', 2 => 'bar', 3 => 'val']);
            });

            $filter->column(1/2, function ($filter) {
                $filter->in('checkbox')->checkbox([1 => 'foo', 2 => 'bar', 3 => 'val']);
                $filter->group('date', function ($group) {
                    $group->gt('大于')->date();
                    $group->lt('小于')->date();
                    $group->nlt('不小于')->date();
                    $group->ngt('不大于')->date();
                    $group->equal('等于')->date();
                });
                $filter->equal('radio', 'radio')->radio(['' => '全部', 1 => '男', 2=> '女']);
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
        $show = new Show(Demo::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('标题'));
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
        $form = new Form(new Demo());

        $form->tab('基本组件', function ($form) {
            $form->icon('icon', __('图标选择'));
            $form->ip('ip', __('IP 输入'));
            $form->url('url', __('URL 输入'));
            $form->switch('switch', __('开关'));
            $form->text('title', __('文本输入'));
            $form->email('email', __('邮箱输入'));
            $form->color('color', __('颜色选择'));
            $form->currency('currency', __('货币输入'));
            $form->rate('rate', __('比例输入'));
            $form->slider('slider', __('滑动选择'));
            $form->password('password', __('密码输入'));
            $form->mobile('mobile', __('电话号码输入'));
            $form->number('number', __('数字输入数字输入'));
            $form->textarea('content', __('Textarea 输入'));
            $form->UEditor('editor', __('富文本编辑'));
        })->tab('选择相关', function ($form) {
            $form->radio('radio', __('Radio选择'))->options([1 => '男', 2=> '女']);
            $form->checkbox('checkbox', __('Checkbox选择'))->options([1 => 'foo', 2 => 'bar', 3 => 'val'])->canCheckAll();
            $form->select('select', __('Select单选'))->options([1 => 'foo', 2 => 'bar', 3 => 'val']);
            $form->multipleSelect('multipleSelect', __('Select多选'))->options([1 => 'foo', 2 => 'bar', 3 => 'val']);
            $form->listbox('listbox', '穿梭多选')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
            $form->divider('表单联动');
            $form->radio('nationality', '国籍')
                ->options([
                    1 => '本国',
                    2 => '外国',
                ])->when(1, function (Form $form) {
                    $form->text('name', '姓名');
                    $form->text('idcard', '身份证');
                })->when(2, function (Form $form) {
                    $form->text('name', '姓名');
                    $form->text('passport', '护照');
                });
            $form->divider('二级联动');
            $form->select('province', '省份')->options([1 => '安徽省', 2 => '江苏省', 3 => '广东省'])->load('city', admin_url('/city'));
            $form->select('city', '城市');
        })->tab('时间相关', function ($form) {
            $form->timezone('timezone', __('时区'));
            $form->time('time', __('时间输入'));
            $form->date('date', __('日期输入'));
            $form->datetime('datetime', __('日期时间输入'));
            $form->timeRange('timeRangeStart', 'timeRangeEnd', __('时间范围选择'));
            $form->dateRange('dateRangeStart', 'dateRangeEnd', __('日期范围选'));
            $form->datetimeRange('datetimeRangeStart', 'datetimeRangeEnd', __('时间日期范围选择'));
        })->tab('文件/图片', function ($form) {
            $form->image('image', __('图片'))->move('/images/demo')->removable()->downloadable();
            $form->multipleImage('multipleImage', __('多图'))->move('/images/demo')->removable()->downloadable()->sortable();
            $form->file('file', __('文件'))->move('/files/demo')->removable()->downloadable();
            $form->multipleFile('multipleFile', __('多文件'))->move('/files/demo')->removable()->downloadable()->sortable();
        })->tab('经纬度', function ($form) {
            $form->latlong('latitude', 'longitude', '经纬度')->height(500);
        });

        // 在表单提交前调用
        $form->submitted(function (Form $form) {
            admin_success('在表单提交前调用');
        });

        // 保存前回调
        $form->saving(function (Form $form) {
            admin_success('保存前回调');
        });

        // 保存后回调
        $form->saved(function (Form $form) {
            admin_success('保存后回调');
        });

        return $form;
    }

    public function city(Request $request)
    {
        $cityMap = [
            1 => [1 => '安庆', 2 => '合肥', 3 => '黄山'],
            2 => [1 => '南京', 2 => '苏州', 3 => '连云港'],
            3 => [1 => '深圳', 2 => '广州', 3 => '东莞'],
        ];
        $provinceId = $request->get('q');

        return $cityMap[$provinceId];
    }

}

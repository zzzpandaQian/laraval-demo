<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '用户列表.xlsx';

    protected $columns = [
        'name'        => '姓名',
        'email'       => '邮箱',
        'mobile'      => '手机',
        'gender'      => '性别',
        'birthdate'   => '出生日期',
        'address'     => '地址',
        'wx_nickname' => '微信昵称',
        'created_at'  => '创建时间',
    ];

    public function map($row) : array
    {
        return [
            $row->name,
            $row->email,
            $row->mobile,
            config('array.gender')[$row->gender],
            $row->birthdate,
            $row->address,
            $row->wx_nickname,
            $row->created_at,
        ];
    }
}

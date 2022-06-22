<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '联系列表.xlsx';

    protected $columns = [
        'name'    => '姓名',
        'email'   => '邮箱',
        'message' => '信息',
        'status'  => '状态',
    ];

    public function map($row) : array
    {
        return [
            $row->name,
            $row->email,
            $row->message,
            $row->status == 0 ? '未读' : '已读',
        ];
    }
}

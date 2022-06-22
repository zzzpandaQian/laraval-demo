<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class NewsExcelExpoter extends AbstractExporter
{
    public function export()
    {
        Excel::create('新闻表', function ($excel) {
            $excel->sheet('Sheetname', function ($sheet) {

                // 这段逻辑是从表格数据中取出需要导出的字段
                $rows = collect($this->getData())->map(function ($item) {
                    return array_only($item, ['id', 'title','status','created_at']);
                });
                $cellData = ['ID', '标题', '状态', '创建时间'];
                $sheet->rows(array($cellData));
                $sheet->rows($rows);
            });
        })->export('xls');
    }
}

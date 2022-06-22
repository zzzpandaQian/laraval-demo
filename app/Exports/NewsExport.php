<?php
namespace App\Exports;

use App\Models\News;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return News::query();
    }

    /**
    * @var Product $item
    */
    public function map($item): array
    {
        return [
            $item->title,
            $item->image,
            $item->tag,
            $item->short,
            $item->content,
            $item->read_count,
            $item->status,
            
        ];
    }


    public function headings(): array
    {
        return [
            '标题',
            '缩略图',
            'TAG',
            '简要',
            '内容',
            '阅读次数',
            '状态',
        ];
    }
}
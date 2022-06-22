<?php
namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Contact::query();
    }

    /**
    * @var Product $item
    */
    public function map($item): array
    {
        return [
            $item->name,
            $item->email,
            $item->message,
            $item->status == 0 ? '未读' : '已读',

        ];
    }


    public function headings(): array
    {
        return [
            '姓名',
            '邮箱',
            '信息',
            '状态',
        ];
    }
}

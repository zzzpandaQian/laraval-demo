<?php

namespace App\Admin\Actions\Post;

use PDF;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class BatchReplicate extends BatchAction
{
    public $name = '批量打印';

    public function handle(Collection $collection)
    {
        if (count($collection) > 0) {

            $data = [
                'collection' => $collection,
            ];

            $pdf_url = storage_path('app/public/pdf/faq.pdf');
            PDF::loadView('admin.pdf.faq', $data)->save($pdf_url);
        }


        admin_success("数据已导出。", "<a href='" . env('APP_URL') . '/storage/pdf/faq.pdf' . "' target='_blank'>点击下载</a>");
        return $this->response()->success('数据已导出')->refresh();
    }

    //     public function html()
    //     {
    //         return "<a href='" . env('APP_URL') . '/storage/pdf/faq.pdf' . "' target='_blank'>点击下载</a>";
    //     }
}

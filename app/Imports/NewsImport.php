<?php

namespace App\Imports;

use Log;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NewsImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    private $_successRows = 0;
    private $_failedRows = 0;

    public function model(array $row)
    {
        if (!isset($row['title'])) {
            ++$this->_failedRows;
            return null;
        }

        $news_category_id = Input::post('news_category_id');
        // 跳过重复的数据
        $News = News::where('title', $row['title'])->where('news_category_id', $news_category_id)->first();
        if ($News) {
            ++$this->_failedRows;
            return null;
        }
        ++$this->_successRows;
        return new News(
            [
                'title'     => $row['title'],
                'news_category_id'    => $news_category_id,
            ]
        );
    }

    /**
     * 支持有多个sheet的excel文件，避免因多sheet产生导入错误
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function getSuccessRows(): int
    {
        return $this->_successRows;
    }

    public function getFailedRows(): int
    {
        return $this->_failedRows;
    }
}

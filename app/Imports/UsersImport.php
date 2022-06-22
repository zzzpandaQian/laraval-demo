<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToModel, WithHeadingRow, WithMultipleSheets
{

    private $_successRows = 0;
    private $_failedRows = 0;

    public function model(array $row)
    {
        // 跳过值为空的数据
        if (!isset($row['name'])) {
            ++$this->_failedRows;
            return null;
        }

        // 跳过重复的数据
        $user = User::where('email', $row['email'])->first();
        if ($user) {
            ++$this->_failedRows;
            return null;
        }

        ++$this->_successRows;
        return new User(
            [
                'name'     => $row['name'],
                'email'    => $row['email'],
                'password' => Hash::make($row['password']),
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

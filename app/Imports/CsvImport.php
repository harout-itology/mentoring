<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CsvImport implements ToCollection, WithValidation, WithStartRow
{
    private $firstRow;

    public function __construct($firstRow){
        $this->firstRow = $firstRow;
    }

    /**
    * @param Array $row
    */
    public function collection(Collection $rows)
    {
       //
    }

    public function rules(): array
    {
        return [
            '0' => function($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('The Name column is a mandatory filed');
                }
            },
            '1' => function($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('The email column is a mandatory filed.');
                }
                else if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-\_]+\.)+[a-z]{2,6}$/ix", $value)) {
                    $onFailure('The Email column has an invalid value');
                }
            },
            '2' => function($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('The Division column is a mandatory filed');
                }
            },
            '3' => function($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('The Age column is a mandatory filed');
                }
                else if (!is_numeric($value)) {
                    $onFailure('The Age column has an invalid value');
                }
            },
            '4' => function($attribute, $value, $onFailure) {
                if (!is_numeric($value) || $value < -12 || $value > 12 ) {
                    $onFailure('The Timezone column has an invalid value');
                }
            }
        ];
    }



    /**
     * @return int
     */
    public function startRow(): int
    {
        return  $this->firstRow;
    }
}

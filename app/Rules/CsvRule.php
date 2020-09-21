<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CsvRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $types =[
            'application/csv',
            'text/csv',
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.msexcel',
            'text/comma-separated-values'
        ];
        if(in_array($value->getClientMimeType(), $types)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The file must be a file of type: csv.';
    }
}


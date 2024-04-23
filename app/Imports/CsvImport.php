<?php

namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CsvImport implements ToCollection, WithMultipleSheets {
    public function collection(Collection $rows) {
        return $rows; //add this line
    }
    public function sheets(): array {
        return [
            0 => new FirstSheetImport(),
        ];
    }
}
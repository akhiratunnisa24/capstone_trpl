<?php

namespace App\Imports;

use App\Models\Absensis;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetImport implements WithMultipleSheets
{
    protected $sheetNames;

    public function __construct(array $sheetNames)
    {
        $this->sheetNames = $sheetNames;
    }

    public function sheets(): array
    {
        $sheetImports = [];
        
        foreach ($this->sheetNames as $index => $sheetName) {
            $sheetImports[$index] = new AbsensisImport($sheetName);
        }
        return $sheetImports;
    }
}

<?php

namespace App\Exports;

use App\Models\Tidakmasuk;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TidakmasukExport implements FromView, ShouldAutoSize
{
   //UNTUK DATA ABSENSI BERDASARKAN FILTER
   protected $idkaryawan;
   protected $data;

   function __construct($data, $idkaryawan) {
       $this->data = $data;
       $this->idkaryawan = $idkaryawan;

       // dd($data,$idkaryawan);
   }

   /**
   * @return \Illuminate\Support\Collection
   */

   public function view(): View    
   {
       $tidakmasuk = $this->data;
       $idkaryawan = $this->idkaryawan ;
       
       return view('admin/tidakmasuk/dataTidakMasukExcel', ['tidakmasuk' => $tidakmasuk], ['idkaryawan' => $idkaryawan]);
   }
}

<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class ProductsExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    
    */
    // use Exportable;

    public function __construct(string $from,$to)
    {
        $this->from = $from;
        $this->to = $to;
        return $this;
    }

    public function view(): View
    {
        return view('products.export', [
            'users' => Product::whereBetween(DB::raw('LEFT(created_at,10)'),[$this->from ,$this->to])->get()
        ]);
    }
}



// class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
// {
//     /**
//      * @return \Illuminate\Support\Collection
//      */
//     public function headings(): array
//     {
//         return [
//             'ID',
//             'NAME',
//             'ADDRESS',
//             'COUNTRY',
//             'IMAGE',
//             'FROM DATE',
//             'TO DATE',

//         ];
//     }


//     public function collection()
//     {
//         return Product::select('id', 'name', 'address', 'country', 'image', 'fromdate', 'todate')->get();
//     }

//     public function styles(Worksheet $sheet)
//     {
//         $sheet->getStyle('1')->getFont()->setBold(true);

//         return [

//             // Style the first row as text center.
//             1   => [
//                 'alignment' => [
//                     'horizontal' => Alignment::HORIZONTAL_CENTER,
//                     'vertical' => Alignment::VERTICAL_CENTER,
//                     'wrapText' => true,
//                 ]
//             ]
//         ];
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {

//                 $style_text_center = [
//                     'alignment' => [
//                         'horizontal' => Alignment::HORIZONTAL_CENTER
//                     ]
//                 ];

//                 $event->sheet->insertNewRowBefore(1);

//                 $event->sheet->setCellValue('A1','My Products Report');

//                 $event->sheet->mergeCells(sprintf('A1:G1'));

//                 $event->sheet->getStyle('A1:G1')->applyFromArray($style_text_center);


//             },
//         ];
//     }
// }

//************************************************************************************************************ */

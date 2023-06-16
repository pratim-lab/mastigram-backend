<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Model\Category;
use App\Model\Product;
use App\Model\Specification;
use App\Model\SpecificationOption;

class ProductExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $results;

    public function collection()
    {
        $this->results = Product::select('categories_id','product_name')->limit(1)->get();
        return $this->results;
    }

    public function headings(): array
    {
        return [
            "Category",
            "Product Name",
            "Short Description",
            "Product Description",
            "Delivery Information",
            "Alt Keyword",
            "Meta Title",
            "Meta Keyword",
            "Meta Description",
            "Orginal price",
            "Selling price",
            "Tax Class",
            "Product SKU",
            "Product Stock",
            "Shipping Methods",
            "Weight KG",
            "Length",
            "Width",
            "Height",

          ];
    }
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {

                $row_count = 30;
                // set dropdown column
                $drop_column = 'A';

                $category_list = Category::join('taxonomies as taxonomy', 'categories.taxonomy_id', '=', 'taxonomy.id')->where('categories.parent_id',null)->pluck('taxonomy.title', 'categories.id');
                $catlst = array();
                foreach ($category_list as $key => $cat) {
                    $catlst[] = $key."->".$cat;
                }

                // set dropdown list for first data row
                $validation = $event->sheet->getCell("A2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.'); 
                $validation->setFormula1( '"'.implode(',', $catlst).'"' );

                //clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                }

                //$specifications = Specification::active()->get();
                //$cellKey = "T";
                // foreach ($specifications as $key => $specification) {
                //    $event->sheet->SetCellValue( $cellKey."1",$specification->title);
                  
                //    $specificationsOption = SpecificationOption::where('specification_id',$specification->id)->active()->pluck('title', 'id');


                //     $catlst1 = array();
                //     foreach ($specificationsOption as $key => $value) {
                //         $catlst1[] = $key."->".$value;
                //     }
                //     //dd($catlst1);
                //     $validation = $event->sheet->getCell($cellKey."2")->getDataValidation();
                //     $validation->setType(DataValidation::TYPE_LIST );
                //     $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                //     $validation->setAllowBlank(false);
                //     $validation->setShowInputMessage(true);
                //     $validation->setShowErrorMessage(true);
                //     $validation->setShowDropDown(true);
                //     $validation->setErrorTitle('Input error');
                //     $validation->setError('Value is not in list.');
                //     $validation->setPromptTitle('Pick from list');
                //     $validation->setPrompt('Please pick a value from the drop-down list.'); 
                //     $validation->setFormula1( '"'.implode(',', $catlst1).'"' );
                //     //dd($validation);
                //     for ($i = 3; $i <= $row_count; $i++) {
                //         $event->sheet->getCell("{$cellKey}{$i}")->setDataValidation(clone $validation);
                //     }

                //  ++$cellKey;
                // }
               
                
            },
        ];
    }
     public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}

<?php

namespace App\Imports;

use App\Model\Product;
use App\Model\ProductAttribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if($key != 0){
                if($row[1] != ''){      
                    $product = [
                        'categories_id'=>$row[0],
                        'product_type'=>'simple',
                        'product_name'=>$row[1],
                        'slug'=> Str::slug($row[1], '-'),
                        'description'=>$row[3],
                        'delivery_information'=>$row[4],
                        'care_instruction'=>$row[2],
                        'alt_key'=>$row[5],
                        'meta_keyword'=>$row[6],
                        'meta_keyword'=>$row[7],
                        'meta_description'=>$row[8],
                        'created_by'=>1,
                        'status'=>'D'

                    ];
                    $product = Product::updateOrCreate(['slug'=> Str::slug($row[1], '-')],$product);
                    
                    if($product){
                        $price = [
                            'product_id'=>$product->id,
                            'sku'=>$row[12],
                            'stock'=>$row[13],
                            'orginal_price'=>$row[9],
                            'price'=>$row[10],
                            'gst'=>$row[11],
                            'weight'=>$row[15],
                            'length'=>$row[16],
                            'width'=>$row[17],
                            'height'=>$row[18],
                        ];
                        //dd($price);
                        ProductAttribute::updateOrCreate(['product_id'=>$product->id],$price);
                    }
                   // echo "<pre>";
                    //print_r($row);
                    //die;
                }
               // dd($row);
            } 
            //dd($key);
            //die;
           
        }
        //return '';
        
    }
}

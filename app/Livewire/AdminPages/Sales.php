<?php

namespace App\Livewire\AdminPages;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Sales extends Component
{
    use WithFileUploads;
    public $category_name;
    public $product_name;
    public $product_category;
    public $product_pic;
    public $prod_description;
    public $product_price;

    public $small_size;
    public $medium_size;
    public $large_size;
    public $ad_image;

    public $path;
    public $ad_path;
   

    public function submitCategory(){
        $this->validate([
            "category_name" => "required",
        ]);

        Category::create([
            'category_name' => $this->category_name,
            'small_size' => $this->small_size,
            'medium_size' => $this->medium_size,
            'large_size' => $this->large_size,
            'status' => 'available',
        ]);

        $this->reset('category_name','small_size','medium_size','large_size');
        session()->flash('success_category','Category Added Successfully!');



    }

    public function submitProduct(){
        $this->validate([
            'product_name' => 'required',
            'product_category' => 'required',
            'product_pic' => 'required|file|mimes:png,jpeg,jpg,webp|max:2048',
            'prod_description' => 'required',
            'product_price' => 'required',
        ]);

        if($this->product_pic){
            $this->path = $this->product_pic->store('productImages','public');
        }else{
            $this->path = '';
        }

       

        Product::create([
            'product_name'=> $this->product_name,
            'category_id' => $this->product_category,
            'photo_path' => $this->path,
            'description' => $this->prod_description,
            'price'=> $this->product_price,
            'status' => 'available'

        ]);

        $this->reset('product_name','product_category','product_pic','prod_description','product_price');
        session()->flash('success_product','Product Added Successfully!');

    }

    public function submitAd(){
        $this->validate([
            'ad_image' => 'required|file|mimes:png,jpeg,jpg,webp|max:2048'
        ]);
        if($this->ad_image){
            $this->ad_path = $this->ad_image->store('adImages','public');
        }else{
            $this->ad_image = null;
        }

        Advertisement::create([
            'ad_path' => $this->ad_path,
        ]);

        $this->reset('ad_image');
        session()->flash('ad_success', 'Ad posted successfully!');


    }
    public function render()
    {
        return view('livewire.admin-pages.sales');
    }
}

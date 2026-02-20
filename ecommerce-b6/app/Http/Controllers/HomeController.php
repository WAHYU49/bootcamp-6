<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $name = "<b>Wahyu C</b>";

        $products = [
           [
                'id' => 1,
                'name' => 'Product 1',
                'description' => 'This is the description for Product 1',
                'price' => 100000,
                'image' => '/images/products/Mengapa-Website-Dianggap-Sebagai-Alat-Bisnis-yang-Sangat-Powerful.jpg',
           ],
           [
                'id' => 2,
                'name' => 'Product 2',
                'description' => 'This is the description for Product 2',
                'price' => 150000,
                'image' => '/images/products/product2.jpg',
           ],
           [
                'id' => 3,
                'name' => 'Product 3',
                'description' => 'This is the description for Product 3',
                'price' => 200000,
                'image' => '/images/products/product3.jpg',
           ]   
        ];

        $is_logged_in = false;

        $products = Product::with('product_category')
                        ->where('stock', '>', 20)
                        ->orderBy('stock', 'desc')
                        ->paginate(6);

        return view('home', compact('name', 'products', 'is_logged_in'));

     
    }

    public function productDetail($id)
    {
        $product = Product::with('product_category')
                        ->findOrFail($id); // nampilin detail produk berdasarkan id

        $recommendedProducts = Product::where('product_category_id', $product->product_category_id)
                                    ->where('id', '!=', $product->id)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get(); //nampilin banyak produk rekomendasi

        return view('product-detail', compact('product', 'recommendedProducts'));
    }
}

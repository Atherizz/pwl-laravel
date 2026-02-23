<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function category($category)
    {
        // Data dummy untuk produk
        $products = [
            'food-beverage' => [
                ['id' => 1, 'name' => 'Nasi Goreng', 'price' => 25000],
                ['id' => 2, 'name' => 'Ayam Bakar', 'price' => 30000],
                ['id' => 3, 'name' => 'Es Teh Manis', 'price' => 5000],
                ['id' => 4, 'name' => 'Jus Jeruk', 'price' => 10000],
            ],
            'beauty-health' => [
                ['id' => 5, 'name' => 'Facial Wash', 'price' => 45000],
                ['id' => 6, 'name' => 'Body Lotion', 'price' => 55000],
                ['id' => 7, 'name' => 'Vitamin C', 'price' => 150000],
                ['id' => 8, 'name' => 'Face Mask', 'price' => 35000],
            ],
            'home-care' => [
                ['id' => 9, 'name' => 'Sabun Cuci Piring', 'price' => 12000],
                ['id' => 10, 'name' => 'Detergen', 'price' => 25000],
                ['id' => 11, 'name' => 'Pembersih Lantai', 'price' => 18000],
                ['id' => 12, 'name' => 'Lap Microfiber', 'price' => 15000],
            ],
            'baby-kid' => [
                ['id' => 13, 'name' => 'Popok Bayi', 'price' => 85000],
                ['id' => 14, 'name' => 'Susu Formula', 'price' => 120000],
                ['id' => 15, 'name' => 'Baby Oil', 'price' => 35000],
                ['id' => 16, 'name' => 'Mainan Edukasi', 'price' => 95000],
            ],
        ];

        $categoryName = ucwords(str_replace('-', ' ', $category));
        $productList = $products[$category] ?? [];

        return view('products.category', [
            'category' => $categoryName,
            'products' => $productList
        ]);
    }
}

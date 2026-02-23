<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        // Data dummy untuk transaksi penjualan
        $sales = [
            [
                'id' => 'TRX001',
                'date' => '2025-02-23',
                'customer' => 'Ahmad Rizki',
                'items' => [
                    ['product' => 'Nasi Goreng', 'qty' => 2, 'price' => 25000],
                    ['product' => 'Es Teh Manis', 'qty' => 2, 'price' => 5000],
                ],
                'total' => 60000,
                'status' => 'Completed'
            ],
            [
                'id' => 'TRX002',
                'date' => '2025-02-23',
                'customer' => 'Siti Nurhaliza',
                'items' => [
                    ['product' => 'Facial Wash', 'qty' => 1, 'price' => 45000],
                    ['product' => 'Face Mask', 'qty' => 3, 'price' => 35000],
                ],
                'total' => 150000,
                'status' => 'Completed'
            ],
            [
                'id' => 'TRX003',
                'date' => '2025-02-23',
                'customer' => 'Budi Santoso',
                'items' => [
                    ['product' => 'Popok Bayi', 'qty' => 2, 'price' => 85000],
                ],
                'total' => 170000,
                'status' => 'Pending'
            ],
        ];

        return view('sales.index', ['sales' => $sales]);
    }
}

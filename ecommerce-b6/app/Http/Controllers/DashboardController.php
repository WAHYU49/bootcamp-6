<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            [
                'name' => 'Products',
                'count' => Product::count(),
                'description' => 'Total products available',
                'color'=>'blue-500',
                'icon'=>'box',
            ],
            [
                'name' => 'Product Clicks',
                'count' => Product::sum('click'),
                'description' => 'Total product clicks',
                'color'=>'green-500',
                'icon'=>'web_traffic',
            ],
            [
                'name' => 'Categories',
                'count' => ProductCategory::count(),
                'description' => 'Total product categories',
                'color'=>'yellow-500',
                'icon'=>'category',
            ],
            [
                'name' => 'Users',
                'count' => User::count(),
                'description' => 'Total registered users',
                'color'=>'gray-500',
                'icon'=>'group',
            ],
        ];
        // Example transaction data for the last 7 days
        $transactionChart = [
            'labels' => [
                now()->subDays(6)->format('d-M'),
                now()->subDays(5)->format('d-M'),
                now()->subDays(4)->format('d-M'),
                now()->subDays(3)->format('d-M'),
                now()->subDays(2)->format('d-M'),
                now()->subDays(1)->format('d-M'),
                now()->format('d-M'),
            ],
            'data' => [12, 19, 7, 15, 10, 22, 17], // Example data
            'nominal' => [1200000, 2100000, 900000, 1750000, 1100000, 2500000, 1800000], // Example nominal in rupiah
        ];

        $latestTransactionOnTable = [
            [
                'id' => 'TRX001',
                'user' => 'John Doe',
                'amount' => 500000,
                'status' => 'Completed',
                'date' => '2026-02-25 14:30:00',
            ],
            [
                'id' => 'TRX002',
                'user' => 'Jane Smith',
                'amount' => 250000,
                'status' => 'Pending',
                'date' => '2026-02-25 16:10:00',
            ],
            [
                'id' => 'TRX003',
                'user' => 'Alice Johnson',
                'product' => 'Product C',
                'amount' => 750000,
                'status' => 'Completed',
                'date' => '2026-02-24 10:05:00',
            ],
            [
                'id' => 'TRX004',
                'user' => 'Bob Brown',
                'amount' => 300000,
                'status' => 'Cancelled',
                'date' => '2026-02-23 09:00:00',
            ],  
        ];


        return view('admin.dashboard', compact
        ('data', 'transactionChart', 'latestTransactionOnTable'));
    }
}

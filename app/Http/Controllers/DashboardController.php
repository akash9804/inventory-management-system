<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
    {
        $totalSales = SalesOrder::sum('total');
        $totalOrders = SalesOrder::count();
        $productCounts = Product::count();
        $lowStockProducts = Product::where('quantity', '<', 5)->get();

        return view('dashboard', compact('totalSales', 'totalOrders', 'lowStockProducts', 'productCounts'));
    }
}

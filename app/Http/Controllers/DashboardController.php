<?php

namespace App\Http\Controllers;

use App\Models\Order;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $orders = Order::all();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('totalAmount');
    $todaySales = Order::whereDate('created_at', now())->sum('totalAmount');
    $yesterdaySales = Order::whereDate('created_at', today()->subDays(1))->sum('totalAmount');

    // Step 1: Initialize all 12 months
    $monthlySales = [
        'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
        'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
        'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
    ];

    // Step 2: Fetch revenue grouped by month
    $monthlyOrderPrices = DB::table('orders')
        ->select(DB::raw('SUM(totalAmount) as totalAmount'), DB::raw('MONTH(created_at) as month'))
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

    foreach ($monthlyOrderPrices as $monthlyOrderPrice) {
        $monthName = date('M', mktime(0, 0, 0, $monthlyOrderPrice->month, 1));

        // Assign revenue to correct month
        $monthlySales[$monthName] = $monthlyOrderPrice->totalAmount;
    }

    // Step 3: Prepare data for ApexCharts
    $monthlySalesData = [
        'labels' => array_keys($monthlySales),
        'series' => [array_values($monthlySales)]
    ];

    // Step 4: This month & previous month revenue
    $currentMonthName = date('M');
    $previousMonthName = date('M', strtotime('-1 month'));

    $thisMonth = $monthlySales[$currentMonthName];
    $previousMonth = $monthlySales[$previousMonthName];

    // Step 5: Payment method percentage
    $payments = Payment::all();

    $paymentMethodNames = [
        '53201' => 'Paypal',
        '53202' => 'Cash',
        '53203' => 'Online Banking',
        '53204' => 'E-Wallet',
        '53205' => 'Credit Card',
    ];

    // Initialize counts
    $paymentMethods = [
        'Paypal' => 0,
        'Cash' => 0,
        'Online Banking' => 0,
        'E-Wallet' => 0,
        'Credit Card' => 0
    ];

    foreach ($payments as $payment) {
        $methodId = $payment->payment_method_id;
        $methodName = $paymentMethodNames[$methodId];
        $paymentMethods[$methodName]++;
    }

    // Convert to percentage
    foreach ($paymentMethods as $method => $count) {
        $paymentMethods[$method] = $totalOrders > 0
            ? ($count / $totalOrders) * 100
            : 0;
    }

    return view('admin.dashboard', compact(
        'orders', 'totalOrders', 'totalRevenue',
        'monthlySalesData', 'thisMonth', 'previousMonth',
        'paymentMethods', 'todaySales', 'yesterdaySales'
    ));
}


}

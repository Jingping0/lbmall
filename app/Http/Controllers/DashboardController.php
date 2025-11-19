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

        // Fetch order prices grouped by month
        $monthlyOrderPrices = DB::table('orders')
            ->select(DB::raw('SUM(totalAmount) as totalAmount'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
    
        $monthlySales = [];
        $thisMonthAmount = 0;
        $previousMonthAmount = 0;
    
        // Get the current month and previous month
        $currentMonth = date('M');
        $previousMonth = date('M', strtotime('-1 month'));
    
        foreach ($monthlyOrderPrices as $monthlyOrderPrice) {
            $monthName = date('M', mktime(0, 0, 0, $monthlyOrderPrice->month, 1));
            $monthlySales[$monthName] = $monthlyOrderPrice->totalAmount;
    
            // Check if the current month matches the month in the loop
            if ($currentMonth == $monthName) {
                $thisMonthAmount = $monthlyOrderPrice->totalAmount;
            }
    
            // Check if the previous month matches the month in the loop
            if ($previousMonth == $monthName) {
                $previousMonth = $monthlyOrderPrice->totalAmount;
            }
        }
    
        // Sample data for demonstration, replace this with your actual data
        $monthlySalesData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'series' => [array_values($monthlySales)],
        ];
    
        $payments = Payment::all();
        // Calculate the percentage of each payment method
        $paymentMethods = [
            '53201' => 0,
            '53202' => 0,
            '53203' => 0,
            '53204' => 0,
            '53205' => 0,
        ];

        $paymentMethodNames = [
            '53201' => 'Paypal',
            '53202' => 'Cash',
            '53203' => 'Online Banking',
            '53204' => 'E-Wallet',
            '53205' => 'Credit Card',
        ];

        foreach ($payments as $payment) {
            $paymentMethod = $payment->payment_method_id;
            $paymentMethods[$paymentMethod]++;
        }

        // Calculate the percentage for each payment method
        // Avoid division by zero
        if ($totalOrders > 0) {
            foreach ($paymentMethods as $method => $count) {
                $paymentMethods[$paymentMethodNames[$method]] = ($count / $totalOrders) * 100;
                unset($paymentMethods[$method]);
            }
        } else {
            // No orders, so all percentages = 0
            foreach ($paymentMethods as $method => $count) {
                $paymentMethods[$paymentMethodNames[$method]] = 0;
                unset($paymentMethods[$method]);
            }
        }


        return view('admin.dashboard', compact('orders', 'totalOrders', 'totalRevenue', 'monthlySalesData', 'thisMonthAmount', 'previousMonth','paymentMethods','todaySales','yesterdaySales'));
    }

}

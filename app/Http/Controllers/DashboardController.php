<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()?->hasRole(['admin', 'superadmin'])) {
            return $this->dashboardAdmin();
        }
        return view('dashboard.index');
    }

    private function dashboardAdmin(): View|Factory|Application
    {
        $orders = OrderService::join('services', 'order_services.service_id', '=', 'services.id')
            ->selectRaw('DATE_FORMAT(date, "1-%m-%Y") as date')
            ->selectRaw('COUNT(*) as total_order')
            ->selectRaw('SUM(services.price) as total_income')
            ->groupByRaw('DATE_FORMAT(date, "1-%m-%Y")')
            ->get()
            ->map(function ($item) {
                $item->date = date('F Y', strtotime($item->date));
                return $item;
            });

        return view('dashboard.admin.index', [
            'orders' => (object)[
                'incomes' => $orders->pluck('total_income')->toArray(),
                'dates' => $orders->pluck('date')->toArray(),
                'orders' => $orders->pluck('total_order')->toArray(),
            ],
        ]);
    }
}

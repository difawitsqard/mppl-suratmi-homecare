<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use App\Models\User;
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
        if (auth()->user()?->hasRole(['customer'])) {
            return $this->dashboardCustomer();
        }
        if (auth()->user()?->hasRole(['therapist'])) {
            return $this->dashboardTherapist();
        }
        return abort(403);
    }

    private function dashboardAdmin(): View|Factory|Application
    {
        $customers = User::role('customer')->get();
        $therapists = User::role('therapist')->get();
        $OrderServices = OrderService::all();
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

        $totalPending = $OrderServices->filter(function ($order) {
            return $order->status === 'pending';
        })->count();

        $totalComplete = $OrderServices->filter(function ($order) {
            return $order->status === 'completed';
        })->count();

        return view('dashboard.admin.index', [
            'orders' => (object)[
                'incomes' => $orders->pluck('total_income')->toArray(),
                'dates' => $orders->pluck('date')->toArray(),
                'orders' => $orders->pluck('total_order')->toArray(),
            ],
            'customers' => $customers,
            'therapists' => $therapists,
            'totalPending' => $totalPending,
            'totalComplete' => $totalComplete,
        ]);
    }

    private function dashboardCustomer(): View|Factory|Application
    {
        $OrderService = OrderService::where('customer_id', auth()->user()->id)
            ->with('service', 'testimonial')
            ->orderBy('id', 'desc')
            ->get();

        $totalComplete = $OrderService->filter(function ($order) {
            return $order->status === 'completed';
        })->count();

        $totalCancelReject = $OrderService->filter(function ($order) {
            return $order->status === 'rejected' || $order->status === 'canceled';
        })->count();

        $totalApproved = $OrderService->filter(function ($order) {
            return $order->status === 'approved';
        })->count();

        return view('dashboard.customer.index', compact('OrderService', 'totalComplete', 'totalCancelReject', 'totalApproved'));
    }

    private function dashboardTherapist(): View|Factory|Application
    {
        $OrderServices = OrderService::where('therapist_id', auth()->user()->id)
            ->whereIn('status', ['approved', 'completed'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalComplete = $OrderServices->filter(function ($order) {
            return $order->status === 'completed';
        })->count();

        $totalApproved = $OrderServices->filter(function ($order) {
            return $order->status === 'approved';
        })->count();

        return view('dashboard.therapist.index', compact('OrderServices', 'totalComplete', 'totalApproved'));
    }
}

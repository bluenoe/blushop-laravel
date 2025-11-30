<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Admin: list orders with search and status filter, eager loaded.
     */
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $q = trim((string) $request->input('q', ''));
        $from = (string) $request->query('from', '');
        $to = (string) $request->query('to', '');

        $query = Order::query()
            ->with(['user', 'orderItems.product'])
            ->latest('created_at');

        // Filter by status (use new orders.status column)
        if ($status !== '') {
            $query->where('status', $status);
        }

        // Date range filtering
        if ($from !== '' || $to !== '') {
            if ($from !== '' && $to !== '') {
                $query->whereBetween('created_at', [\Carbon\Carbon::parse($from)->startOfDay(), \Carbon\Carbon::parse($to)->endOfDay()]);
            } elseif ($from !== '') {
                $query->where('created_at', '>=', \Carbon\Carbon::parse($from)->startOfDay());
            } elseif ($to !== '') {
                $query->where('created_at', '<=', \Carbon\Carbon::parse($to)->endOfDay());
            }
        }

        // Search by user name or status
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%");
                })->orWhere('status', 'like', "%{$q}%");
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'status' => $status,
            'search' => $q,
            'from' => $from,
            'to' => $to,
        ]);
    }

    /**
     * Show order details.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Update order status: pending, approved, shipped, cancelled.
     * Maps approved/shipped to payment_status=paid.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'approved', 'shipped', 'cancelled']),
            ],
        ]);

        $status = $data['status'];

        $newPayment = match ($status) {
            'pending' => 'pending',
            'cancelled' => 'cancelled',
            'approved', 'shipped' => 'paid',
        };

        $order->update([
            'payment_status' => $newPayment,
            'status' => $status,
        ]);

        $msg = match ($status) {
            'pending' => "Order #{$order->id} set to pending.",
            'approved' => "Order #{$order->id} approved.",
            'shipped' => "Order #{$order->id} marked as shipped!",
            'cancelled' => "Order #{$order->id} cancelled.",
        };

        return back()->with('success', $msg);
    }
}

<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderCancellationService
{
    /**
     * Allowed statuses for cancellation.
     */
    protected const CANCELLABLE_STATUSES = ['pending'];

    /**
     * Cancel an order with stock restoration.
     *
     * @param Order $order The order to cancel
     * @param string $reason The cancellation reason
     * @param string|null $reasonDetails Additional details (optional)
     * @return bool
     * @throws \Exception If order cannot be cancelled
     */
    public function cancel(Order $order, string $reason, ?string $reasonDetails = null): bool
    {
        // Check if order is cancellable
        if (!$this->isCancellable($order)) {
            throw new \Exception(
                "Order cannot be cancelled. Current status: {$order->status}. Only pending orders can be cancelled."
            );
        }

        // Use transaction to ensure atomicity
        return DB::transaction(function () use ($order, $reason, $reasonDetails) {
            // Build full cancellation reason text
            $fullReason = $reason;
            if ($reasonDetails) {
                $fullReason .= ": {$reasonDetails}";
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancellation_reason' => $fullReason,
                'cancelled_at' => now(),
            ]);

            // Restore stock for each order item
            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);

                    Log::info("Stock restored for product {$item->product_id}", [
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity_restored' => $item->quantity,
                    ]);
                }
            }

            Log::info("Order {$order->id} cancelled successfully", [
                'user_id' => $order->user_id,
                'reason' => $fullReason,
            ]);

            return true;
        });
    }

    /**
     * Check if an order can be cancelled.
     *
     * @param Order $order
     * @return bool
     */
    public function isCancellable(Order $order): bool
    {
        return in_array(strtolower($order->status), self::CANCELLABLE_STATUSES);
    }
}

<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     */
    public Order $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Xác nhận đơn hàng #{$this->order->id} - BluShop",
        );
    }

    /**
     * Get the message content definition.
     */
   public function content(): Content
{
    return new Content(
        markdown: 'emails.orders.placed',
        with: [
            'orderId' => $this->order->id,
            'customerName' => $this->order->user->name ?? 'Quý khách',
            'totalPrice' => number_format($this->order->total_amount, 0, ',', '.') . '₫',
            'shippingAddress' => $this->order->shipping_address,
            'orderItems' => $this->order->orderItems,
        ],
    );
}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

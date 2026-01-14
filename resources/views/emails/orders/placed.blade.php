<x-mail::message>
    # 🎉 Cảm ơn bạn đã đặt hàng!

    Xin chào **{{ $customerName }}**,

    Chúng tôi đã nhận được đơn hàng của bạn và đang tiến hành xử lý.

    <x-mail::panel>
        **Mã đơn hàng:** #{{ $orderId }}
        <br>
        **Tổng thanh toán:** {{ $totalPrice }}
        <br>
        **Địa chỉ nhận hàng:** {{ $shippingAddress }}
    </x-mail::panel>

    ## 🛒 Chi tiết đơn hàng

    <x-mail::table>
        | Sản phẩm | SL | Đơn giá | Thành tiền |
        |:--- |:---:|:---:|:---:|
        @foreach ($orderItems as $item)
        | **{{ $item->product->name ?? 'Sản phẩm' }}** | {{ $item->quantity }} | {{
        number_format($item->price_at_purchase, 0, ',', '.') }}₫ | **{{ number_format($item->price_at_purchase *
        $item->quantity, 0, ',', '.') }}₫** |
        @endforeach
    </x-mail::table>

    <x-mail::button :url="route('orders.show', $orderId)" color="primary">
        Xem chi tiết đơn hàng
    </x-mail::button>

    Nếu bạn có bất kỳ câu hỏi nào, vui lòng trả lời email này hoặc liên hệ hotline.

    Trân trọng,<br>
    **{{ config('app.name') }}**

    <x-mail::subcopy>
        Đây là email tự động, vui lòng không trả lời trực tiếp email này nếu không cần hỗ trợ.
    </x-mail::subcopy>
</x-mail::message>
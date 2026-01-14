<x-mail::message>
    # 🎉 Cảm ơn bạn đã đặt hàng!

    Xin chào **{{ $customerName }}**,

    Chúng tôi đã nhận được đơn hàng của bạn và đang xử lý.

    ---

    ## 📦 Thông tin đơn hàng

    | Thông tin | Chi tiết |
    |:----------|:---------|
    | **Mã đơn hàng** | #{{ $orderId }} |
    | **Tổng thanh toán** | {{ $totalPrice }} |
    | **Địa chỉ giao hàng** | {{ $shippingAddress }} |

    ---

    ## 🛒 Sản phẩm đã đặt

    @foreach ($orderItems as $item)
    - **{{ $item->product->name ?? 'Sản phẩm' }}** × {{ $item->quantity }} — {{ number_format($item->price_at_purchase *
    $item->quantity, 0, ',', '.') }}₫
    @endforeach

    ---

    <x-mail::button :url="config('app.url') . '/profile/orders'" color="primary">
        Xem đơn hàng của bạn
    </x-mail::button>

    ---

    Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc hotline.

    Trân trọng,<br>
    **{{ config('app.name') }}**

    <x-mail::subcopy>
        Đây là email tự động, vui lòng không trả lời trực tiếp email này.
    </x-mail::subcopy>
</x-mail::message>
<x-mail::message>
{{-- LOGO: Cực kỳ quan trọng để định vị thương hiệu --}}
<div style="text-align: center; margin-bottom: 24px;">
<img src="{{ asset('images/logo-blushop.png') }}" alt="BluShop" style="height: 40px; width: auto;">
</div>

<div style="text-align: center;">
<h1 style="font-size: 24px; font-weight: 300; margin-bottom: 10px; color: #000;">Xác nhận đơn hàng #{{ $orderId }}</h1>
<p style="color: #555; font-size: 16px;">Cảm ơn <strong>{{ $customerName }}</strong>, đơn hàng của bạn đã được tiếp nhận.</p>
</div>

{{-- SUMMARY SECTION: Thay thế Panel xám bằng đường kẻ tinh tế --}}
<hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

<div style="display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 14px;">
<div>
    <p style="color: #888; margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Ngày đặt hàng</p>
    <p style="margin: 5px 0 0 0; font-weight: 600;">{{ now()->format('d/m/Y') }}</p>
</div>
<div style="text-align: right;">
    <p style="color: #888; margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Tổng thanh toán</p>
    <p style="margin: 5px 0 0 0; font-weight: 600; font-size: 18px; color: #000;">{{ $totalPrice }}</p>
</div>
</div>

<div style="margin-bottom: 30px;">
<p style="color: #888; margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Địa chỉ giao hàng</p>
<p style="margin: 5px 0 0 0;">{{ $shippingAddress }}</p>
</div>

{{-- PRODUCT TABLE: Tự code HTML để chèn ảnh và căn chỉnh đẹp hơn Markdown --}}
<table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 30px; border-collapse: collapse;">
<thead>
    <tr>
        <th style="text-align: left; padding-bottom: 10px; border-bottom: 1px solid #000; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #888;">Sản phẩm</th>
        <th style="text-align: right; padding-bottom: 10px; border-bottom: 1px solid #000; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #888;">Thành tiền</th>
    </tr>
</thead>
<tbody>
    @foreach ($orderItems as $item)
    <tr>
        <td style="padding: 15px 0; border-bottom: 1px solid #eee; vertical-align: top;">
            <div style="display: flex; align-items: center;">
                {{-- Hình ảnh sản phẩm: Rất quan trọng cho fashion --}}
                {{-- Lưu ý: Phải dùng đường dẫn tuyệt đối (http...) --}}
                <img src="{{ $item->product->image_url ?? asset('images/no-image.jpg') }}" 
                        alt="Product" 
                        style="width: 50px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 2px; background: #f5f5f5;">
                <div>
                    <p style="margin: 0; font-weight: 600; font-size: 14px;">{{ $item->product->name ?? 'Sản phẩm' }}</p>
                    <p style="margin: 4px 0 0 0; color: #888; font-size: 12px;">
                        SL: {{ $item->quantity }} 
                        @if($item->size) | Size: {{ $item->size }} @endif
                        @if($item->color) | Màu: {{ $item->color }} @endif
                    </p>
                </div>
            </div>
        </td>
        <td style="text-align: right; padding: 15px 0; border-bottom: 1px solid #eee; vertical-align: top; font-weight: 500;">
            {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}₫
        </td>
    </tr>
    @endforeach
</tbody>
</table>

{{-- CTA BUTTON: Nút đen chữ trắng mỏng nhẹ --}}
<div style="text-align: center; margin-top: 40px;">
<a href="{{ route('orders.show', $orderId) }}" 
    style="background-color: #000; color: #fff; padding: 12px 30px; text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 0px; display: inline-block;">
    THEO DÕI ĐƠN HÀNG
</a>
</div>

{{-- FOOTER: Tối giản --}}
<div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
<p style="margin: 0; font-size: 12px; color: #999;">Cần hỗ trợ? Liên hệ <a href="mailto:support@blushop.com" style="color: #000; text-decoration: underline;">support@blushop.com</a></p>
</div>

</x-mail::message>
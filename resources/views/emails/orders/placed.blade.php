<x-mail::message>
<div style="text-align: center; margin-bottom: 24px;">
{{-- LOGO: Nhúng trực tiếp từ folder public/images --}}
@if(file_exists(public_path('images/blu-logo.jpg')))
<img src="{{ $message->embed(public_path('images/blu-logo.jpg')) }}" alt="BluShop" style="height: 40px; width: auto;">
@else
<h1 style="margin: 0; color: #000; letter-spacing: 2px;">BLUSHOP</h1>
@endif
</div>

<div style="text-align: center;">
<h1 style="font-size: 24px; font-weight: 300; margin-bottom: 10px; color: #000;">Xác nhận đơn hàng #{{ $orderId }}</h1>
<p style="color: #555; font-size: 16px;">Cảm ơn <strong>{{ $customerName }}</strong>, đơn hàng của bạn đã được tiếp nhận.</p>
</div>

<hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
<tr>
<td style="width: 50%; vertical-align: top;">
<p style="color: #888; margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Ngày đặt hàng</p>
<p style="margin: 5px 0 0 0; font-weight: 600;">{{ now()->format('d/m/Y') }}</p>
</td>
<td style="width: 50%; vertical-align: top; text-align: right;">
<p style="color: #888; margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Tổng thanh toán</p>
<p style="margin: 5px 0 0 0; font-weight: 600; font-size: 18px; color: #000;">{{ $totalPrice }}</p>
</td>
</tr>
</table>

<div style="margin-bottom: 30px;">
<p style="color: #888; margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Địa chỉ giao hàng</p>
<p style="margin: 5px 0 0 0;">{{ $shippingAddress }}</p>
</div>

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
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td style="width: 60px; padding-right: 15px; vertical-align: top;">
@php
// LOGIC XỬ LÝ ẢNH SẢN PHẨM (Embed để hiện trên mail)
$imgSrc = '';
// Đường dẫn file thực tế trên ổ cứng
$diskPath = public_path('storage/' . ($item->product->image ?? '')); 

if (!empty($item->product->image) && file_exists($diskPath)) {
    // Nếu file tồn tại -> Nhúng thẳng vào mail
    $imgSrc = $message->embed($diskPath);
} else {
    // Nếu không có ảnh -> Dùng placeholder online hoặc text
    $imgSrc = 'https://placehold.co/50x60?text=No+Img'; 
}
@endphp
<img src="{{ $imgSrc }}" alt="Img" style="width: 50px; height: 60px; object-fit: cover; border-radius: 2px; background: #f5f5f5;">
</td>
<td style="vertical-align: top;">
<p style="margin: 0; font-weight: 600; font-size: 14px;">{{ $item->product->name ?? 'Sản phẩm' }}</p>
<p style="margin: 4px 0 0 0; color: #888; font-size: 12px;">
SL: {{ $item->quantity }}
</p>
</td>
</tr>
</table>
</td>
<td style="text-align: right; padding: 15px 0; border-bottom: 1px solid #eee; vertical-align: top; font-weight: 500;">
{{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}₫
</td>
</tr>
@endforeach
</tbody>
</table>

<div style="text-align: center; margin-top: 40px;">
<a href="{{ route('orders.show', $orderId) }}" style="background-color: #000; color: #fff; padding: 12px 30px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-block;">THEO DÕI ĐƠN HÀNG</a>
</div>

<div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
<p style="margin: 0; font-size: 12px; color: #999;">Cần hỗ trợ? Liên hệ <a href="mailto:support@blushop.com" style="color: #000; text-decoration: underline;">support@blushop.com</a></p>
</div>
</x-mail::message>
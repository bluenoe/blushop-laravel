<x-mail::message>
{{-- HEADER: LOGO & TITLE --}}
<div style="text-align: center; margin-bottom: 30px;">
@if(file_exists(public_path('images/blu-logo.jpg')))
<img src="{{ $message->embed(public_path('images/blu-logo.jpg')) }}" alt="BluShop" style="height: 35px; width: auto;">
@else
<h1 style="margin: 0; font-size: 24px; letter-spacing: 3px; color: #000; text-transform: uppercase;">BLUSHOP</h1>
@endif
</div>

<div style="text-align: center; margin-bottom: 40px;">
<p style="font-size: 14px; color: #888; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px;">Xác nhận đơn hàng</p>
<h1 style="font-size: 28px; font-weight: 400; margin: 0; color: #000;">#{{ $orderId }}</h1>
<p style="color: #555; font-size: 15px; margin-top: 15px;">Xin chào <strong>{{ $customerName }}</strong>, chúng tôi đã nhận được đơn hàng của bạn.</p>
</div>

{{-- INFO GRID: NGÀY & TỔNG TIỀN --}}
<div style="background: #fafafa; padding: 20px; margin-bottom: 30px;">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td style="width: 50%; vertical-align: top;">
<p style="color: #999; margin: 0; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Ngày đặt hàng</p>
<p style="margin: 5px 0 0 0; font-weight: 600; font-size: 14px;">{{ now()->format('d/m/Y') }}</p>
</td>
<td style="width: 50%; vertical-align: top; text-align: right;">
<p style="color: #999; margin: 0; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Tổng thanh toán</p>
<p style="margin: 5px 0 0 0; font-weight: 600; font-size: 18px; color: #000;">{{ $totalPrice }}</p>
</td>
</tr>
</table>
</div>

<div style="margin-bottom: 40px; border-left: 2px solid #000; padding-left: 15px;">
<p style="color: #999; margin: 0; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Địa chỉ giao hàng</p>
<p style="margin: 5px 0 0 0; font-size: 14px; line-height: 1.5;">{{ $shippingAddress }}</p>
</div>

{{-- PRODUCT LIST --}}
<p style="border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 0; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Chi tiết đơn hàng</p>

<table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse;">
@foreach ($orderItems as $item)
<tr>
{{-- Cột 1: ẢNH + THÔNG TIN --}}
<td style="padding: 20px 0; border-bottom: 1px solid #eee; vertical-align: top;">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
{{-- XỬ LÝ ẢNH --}}
<td style="width: 70px; padding-right: 15px; vertical-align: top;">
@php
$rawPath = $item->product->image_path ?? $item->product->image ?? '';
$finalPath = null;

// Ưu tiên 1: Check đường dẫn trực tiếp
$directCheck = public_path('storage/' . $rawPath);
if (file_exists($directCheck)) {
$finalPath = $directCheck;
} 

// Ưu tiên 2: Quét thư mục recursive (như code trước)
if (!$finalPath && !empty($rawPath)) {
$filename = basename($rawPath); 
$rootDir = public_path('storage/products'); 
if (is_dir($rootDir)) {
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootDir, RecursiveDirectoryIterator::SKIP_DOTS));
foreach ($iterator as $file) {
if ($file->getFilename() === $filename) {
$finalPath = $file->getPathname();
break;
}
}
}
}
@endphp

@if ($finalPath)
<img src="{{ $message->embed($finalPath) }}" alt="Product" style="width: 60px; height: 75px; object-fit: cover; display: block; background: #f5f5f5;">
@else
<div style="width: 60px; height: 75px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 9px; color: #999;">NO IMG</div>
@endif
</td>

{{-- THÔNG TIN SẢN PHẨM --}}
<td style="vertical-align: top;">
<p style="margin: 0; font-weight: 600; font-size: 14px; color: #000;">{{ $item->product->name ?? 'Sản phẩm' }}</p>
<p style="margin: 5px 0 0 0; color: #666; font-size: 12px;">Số lượng: {{ $item->quantity }}</p>
</td>
</tr>
</table>
</td>

{{-- Cột 2: GIÁ TIỀN --}}
<td style="text-align: right; padding: 20px 0; border-bottom: 1px solid #eee; vertical-align: top; width: 120px;">
<p style="margin: 0; font-weight: 600; font-size: 14px;">{{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}₫</p>
</td>
</tr>
@endforeach
</table>

{{-- FOOTER --}}
<div style="text-align: center; margin-top: 50px;">
<a href="{{ route('orders.show', $orderId) }}" style="background-color: #000; color: #fff; padding: 15px 40px; text-decoration: none; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; display: inline-block;">Kiểm tra đơn hàng</a>
</div>

<div style="text-align: center; margin-top: 50px; border-top: 1px solid #eee; padding-top: 30px;">
<p style="margin: 0; font-size: 12px; color: #bbb;">{{ config('app.name') }} Inc. All rights reserved.</p>
<p style="margin: 5px 0 0 0; font-size: 12px;"><a href="mailto:support@blushop.com" style="color: #999; text-decoration: none;">support@blushop.com</a></p>
</div>
</x-mail::message>
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lấy ID của các Category theo Slug chuẩn (từ file CategorySeeder bà gửi)
        $cats = [
            // --- MEN ---
            'men_tops'    => $this->getId('men-t-shirts'),
            'men_hoodies' => $this->getId('men-hoodies'),
            'men_jackets' => $this->getId('men-jackets'),
            'men_pants'   => $this->getId('men-pants'),
            'men_shorts'  => $this->getId('men-shorts'),

            // --- WOMEN ---
            'wmn_tops'      => $this->getId('women-t-shirts'),
            'wmn_dresses'   => $this->getId('women-dresses'),
            'wmn_skirts'    => $this->getId('women-skirts'),
            'wmn_blouses'   => $this->getId('women-blouses'),
            'wmn_cardigans' => $this->getId('women-cardigans'),

            // --- ACCESSORIES ---
            'acc_bags'    => $this->getId('accessories-bags'),
            'acc_caps'    => $this->getId('accessories-caps'),
            'acc_socks'   => $this->getId('accessories-socks'),
            'acc_jewelry' => $this->getId('accessories-jewelry'),
            'acc_watches' => $this->getId('accessories-watches'),

            // --- STATIONERY ---
            'sta_mugs'      => $this->getId('stationery-mugs'),
            'sta_notebooks' => $this->getId('stationery-notebooks'),
            'sta_tech'      => $this->getId('stationery-tech'),
            'sta_stickers'  => $this->getId('stationery-stickers'),
        ];

        // 2. Chạy lệnh Update hàng loạt dựa trên "Từ khóa" trong tên sản phẩm

        // ================= MEN =================
        $this->updateCat($cats['men_tops'], ['Essential Tee', 'Graphic Tee', 'Polo', 'Linen Shirt', 'Mock Neck', 'Boxy Fit', 'Striped Tee']);
        $this->updateCat($cats['men_hoodies'], ['Hoodie', 'Pullover']);
        $this->updateCat($cats['men_jackets'], ['Bomber', 'Denim Trucker', 'Windbreaker', 'Flannel', 'Varsity', 'Puffer Vest', 'Track Jacket', 'Raincoat']);
        $this->updateCat($cats['men_pants'], ['Cargo', 'Chinos', 'Joggers', 'Jeans', 'Sweatpants']);
        $this->updateCat($cats['men_shorts'], ['Shorts', 'Swim']); // Ưu tiên Shorts

        // ================= WOMEN =================
        // Lưu ý: Các từ khóa của nữ phải khác nam hoặc chạy sau để ghi đè nếu cần
        $this->updateCat($cats['wmn_tops'], ['Cropped Tee', 'Baby Tee', 'Ribbed Tank', 'Camisole', 'Bodysuit', 'Knit Vest', 'Wrap Top', 'Soft Hoodie']); // Hoodie hồng cho vào top hoặc tạo category Hoodie nữ nếu muốn
        $this->updateCat($cats['wmn_dresses'], ['Dress', 'Lounge Set']);
        $this->updateCat($cats['wmn_skirts'], ['Skirt']);
        $this->updateCat($cats['wmn_blouses'], ['Blouse', 'Off-Shoulder']);
        $this->updateCat($cats['wmn_cardigans'], ['Cardigan', 'Blazer', 'Trench', 'Puffer']); // Gộp áo khoác nữ vào Cardigans tạm

        // Phân loại thêm quần nữ (Vì trong CategorySeeder bà chưa có Women Pants, tui tạm cho vào Skirts hoặc Dresses)
        $this->updateCat($cats['wmn_skirts'], ['Leggings', 'Biker', 'Wide Leg']);

        // ================= ACCESSORIES =================
        $this->updateCat($cats['acc_bags'], ['Bag', 'Backpack', 'Sleeve', 'Pouch', 'Keyring', 'Lanyard', 'Wallet', 'Card Holder', 'Umbrella', 'Yoga Mat']);
        $this->updateCat($cats['acc_caps'], ['Cap', 'Hat', 'Beanie', 'Sunglasses']);
        $this->updateCat($cats['acc_socks'], ['Socks']);

        // ================= STATIONERY & TECH =================
        $this->updateCat($cats['sta_mugs'], ['Mug', 'Tumbler', 'Bottle', 'Thermos']);
        $this->updateCat($cats['sta_notebooks'], ['Notebook', 'Planner', 'Sketchbook', 'Pen']);
        $this->updateCat($cats['sta_tech'], ['Mouse Pad', 'Desk Mat', 'Laptop Stand', 'Cable', 'Phone Case', 'Airpods']);
        $this->updateCat($cats['sta_stickers'], ['Sticker', 'Decal']);

        $this->command->info('✅ Đã phân loại xong toàn bộ sản phẩm!');
    }

    // Hàm phụ trợ để lấy ID danh mục
    private function getId($slug)
    {
        return DB::table('categories')->where('slug', $slug)->value('id');
    }

    // Hàm phụ trợ để update DB
    private function updateCat($categoryId, array $keywords)
    {
        if (!$categoryId) return;

        foreach ($keywords as $keyword) {
            // Update tất cả sản phẩm có tên chứa từ khóa này
            DB::table('products')
                ->where('name', 'LIKE', "%{$keyword}%")
                ->update(['category_id' => $categoryId]);
        }
    }
}

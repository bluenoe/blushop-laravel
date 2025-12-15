<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = now();

        DB::table('users')->insert([
            // ===== ADMIN (2) =====
            [
                'name' => 'Admin System',
                'email' => 'admin@blushop.com',
                'password' => Hash::make('1'),
                'is_admin' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Admin Manager',
                'email' => 'manager@blushop.com',
                'password' => Hash::make('2'),
                'is_admin' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ===== ENGLISH CUSTOMERS (9) =====
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => Hash::make('3'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Emily Brown',
                'email' => 'emily@example.com',
                'password' => Hash::make('4'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@example.com',
                'password' => Hash::make('5'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sophia Wilson',
                'email' => 'sophia@example.com',
                'password' => Hash::make('6'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Daniel Miller',
                'email' => 'daniel@example.com',
                'password' => Hash::make('7'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Oliver King',
                'email' => 'oliver@example.com',
                'password' => Hash::make('8'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Emma Clark',
                'email' => 'emma@example.com',
                'password' => Hash::make('1'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lucas White',
                'email' => 'lucas@example.com',
                'password' => Hash::make('2'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lily Adams',
                'email' => 'lily@example.com',
                'password' => Hash::make('3'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ===== VIETNAMESE CUSTOMERS (9) =====
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'an@example.com',
                'password' => Hash::make('4'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Trần Thị Mai',
                'email' => 'mai@example.com',
                'password' => Hash::make('5'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lê Quốc Huy',
                'email' => 'huy@example.com',
                'password' => Hash::make('6'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Phạm Ngọc Linh',
                'email' => 'linh@example.com',
                'password' => Hash::make('7'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Võ Minh Tuấn',
                'email' => 'tuan@example.com',
                'password' => Hash::make('8'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Đặng Thu Hà',
                'email' => 'ha@example.com',
                'password' => Hash::make('1'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Bùi Thanh Long',
                'email' => 'long@example.com',
                'password' => Hash::make('2'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Hoàng Mỹ Linh',
                'email' => 'mylinh@example.com',
                'password' => Hash::make('3'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Phan Nhật Minh',
                'email' => 'minh@example.com',
                'password' => Hash::make('4'),
                'is_admin' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

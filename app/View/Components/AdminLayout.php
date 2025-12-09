<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Dòng này báo cho Laravel biết:
        // Khi gọi <x-admin-layout> thì hãy lấy file resources/views/layouts/admin.blade.php
        return view('layouts.admin');
    }
}

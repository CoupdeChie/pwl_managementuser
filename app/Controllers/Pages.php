<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function produk()
    {
        return view('pages/produk_view');
    }
    public function keranjang()
    {
        return view('pages/keranjang_view');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        return view('system.settings');
    }

    public function update(Request $request)
    {
        // placeholder, nanti bisa simpan ke table settings
        return back()->with('success', 'Pengaturan sistem disimpan');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        return view('system.backup');
    }

    public function backup()
    {
        Artisan::call('backup:run');

        return back()->with('success', 'Backup database berhasil dibuat');
    }
}

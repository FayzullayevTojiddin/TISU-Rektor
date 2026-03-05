<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMessages = Message::count();
        $pendingMessages = Message::where('status', 'kutilmoqda')->count();
        $answeredMessages = Message::where('status', 'javob_berildi')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalMurojaat = Message::where('type', 'murojaat')->count();
        $totalShikoyat = Message::where('type', 'shikoyat')->count();
        $todayMessages = Message::whereDate('writed_at', today())->count();

        $recentMessages = Message::with('writer')
            ->orderByDesc('writed_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalMessages',
            'pendingMessages',
            'answeredMessages',
            'totalUsers',
            'totalMurojaat',
            'totalShikoyat',
            'todayMessages',
            'recentMessages',
        ));
    }
}

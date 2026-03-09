<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of all student screening histories.
     */
    public function index()
    {
        $histories = ScreeningResponse::with('user.student')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.history.index', compact('histories'));
    }
}

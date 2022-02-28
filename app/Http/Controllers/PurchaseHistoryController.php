<?php

namespace App\Http\Controllers;

use App\Models\CourseBill;

use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class PurchaseHistoryController extends Controller
{
    function purchaseHistory()
    {
        SEOMeta::setTitle('Lịch sử thanh toán');

        $courseBill = CourseBill::with([
            'course' => function ($q) {
                $q->withOnly(['coupon']);
            }
        ])
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('pages.purchase-history', compact(['courseBill']));
    }
}

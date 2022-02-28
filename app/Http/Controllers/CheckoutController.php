<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;


class CheckoutController extends Controller
{
    function checkout()
    {
        SEOMeta::setTitle('Checkout');

        return view('pages.checkout');
    }
}

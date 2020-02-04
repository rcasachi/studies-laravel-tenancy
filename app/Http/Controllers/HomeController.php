<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Website;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $website = app(\Hyn\Tenancy\Environment::class)->tenant();
        $invoices = $website->invoicesIncludingPending();
        
        return view('home')->with( ['invoices' => $invoices ] );
    }

    public function invoice( Request $request, $invoiceId )
    {
        $website = app(\Hyn\Tenancy\Environment::class)->tenant();
        return $website->downloadInvoice($invoiceId, [
            'vendor' => 'Your Company',
            'product' => 'Your Product',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingCartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
}

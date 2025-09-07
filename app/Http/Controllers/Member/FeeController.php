<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeeController extends Controller
{
    public function handleReturn(){
        return "Payment was successful!";
    }
    public function handleCancel(){
        return "Payment was cancelled!";
    }
}

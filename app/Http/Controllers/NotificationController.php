<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index(){

        $product = Product::first();
        Notification::send($product,new WelcomeNotification);
        return view('notification.home');

        dd('done');
    }
}

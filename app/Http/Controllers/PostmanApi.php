<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostmanApi extends Controller
{
    public function getData(){
        return ['name' => 'Pranav','email' => 'pranav@gmail.com','password' => '1234'];
    }
}

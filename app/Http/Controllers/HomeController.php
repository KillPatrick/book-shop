<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function index()
    {
        if(Gate::allows('is-admin')){
            return redirect(route('admin.books.index'));
        } else {
            return redirect(route('user.books.index'));
        }
    }
}

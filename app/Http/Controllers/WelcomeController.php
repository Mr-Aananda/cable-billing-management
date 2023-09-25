<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function root()
    {
        return redirect()
            ->route('dashboard.index');
    }
}

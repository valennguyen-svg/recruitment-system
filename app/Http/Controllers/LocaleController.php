<?php

namespace App\Http\Controllers;

use App\Constants\LocaleConstants;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $request->session()->put(LocaleConstants::SESSION_KEY, $locale);

        return back();
    }
}

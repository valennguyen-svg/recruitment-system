<?php

namespace App\Http\Controllers;

use App\Constants\LocaleConstants;
use App\Http\Requests\SwitchLocaleRequest;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(SwitchLocaleRequest $request): RedirectResponse
    {
        $request->session()->put(
            LocaleConstants::SESSION_KEY,
            $request->validated('locale'),
        );

        return back();
    }
}
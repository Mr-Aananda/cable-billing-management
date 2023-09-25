<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    /**
     * Show change password form.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('password-change.form');
    }

    /**
     * Update current user password.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::default()]
        ]);

        // update user password
        auth()->user()
            ->update([
                'password' => Hash::make($request->new_password)
            ]);

        return redirect()->back()
            ->withSuccess('Password changed successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // direct admin profile
    public function profile()
    {
        $id = auth()->user()->id;
        $userData = User::where('id', $id)->first();
        return view('admin.profile.index')->with(['user' => $userData]);
    }
    // update profile
    public function updateProfile($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ], ['name.required' => 'နာမည်ဖြည့်ရန်']);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData = $this->requestUserData($request);
        $data = User::where('id', $id)->first();
        User::where('id', $id)->update($updateData);
        return back()->with(['massage' => 'User Infomation Updated!']);
    }
    // change password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }
    // change password
    public function changePassword($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = User::where('id', $id)->first();
        $HashPassword = $data->password;
        $oldPassword = $request['oldPassword'];
        $newPassword = $request['newPassword'];
        $confirmPassword = $request['confirmPassword'];

        if (Hash::check($oldPassword, $HashPassword)) { // db same password
            if ($newPassword != $confirmPassword) {
                return back()->with(['errMassage' => 'ComfirmPassword must be equal new password!']);
            } else {
                if (strlen($newPassword) < 6 || strlen($confirmPassword) < 6) {
                    return back()->with(['errMassage' => 'Password much be grather than or equal 6 charactor']);
                } else {
                    $hashed = Hash::make($newPassword, [
                        'rounds' => 12,
                    ]);
                    User::where('id', $id)->update(['password' => $hashed]);
                    return back()->with(['massage' => 'Password Change Success Brabo!']);
                }
            }

        } else {
            return back()->with(['errMassage' => 'Do you remember your password?Pls Try again']);
        }

    }

    // request data form client
    private function requestUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
}

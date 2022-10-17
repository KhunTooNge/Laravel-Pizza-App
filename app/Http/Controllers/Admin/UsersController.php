<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    // direct user page
    public function userList()
    {
        if (Session::has('USER_SEARCH')) {
            Session::forget('USER_SEARCH');
        }
        $userData = User::where('role', 'user')->paginate(7);
        return view('admin.user.userlist')->with(['users' => $userData]);
    }
    // serach user
    public function userSearch(Request $request)
    {
        $response = $this->search('user', $request);
        Session::put('USER_SEARCH', $request->searchData);
        return view('admin.user.userlist')->with(['users' => $response]);
    }
    // delete user
    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['massage' => 'User Data Delete Successful!']);
    }
    // admin page
    public function adminList()
    {
        if (Session::has('ADMIN_SEARCH')) {
            Session::forget('ADMIN_SEARCH');
        }
        $userData = User::where('role', 'admin')->paginate(7);
        return view('admin.user.adminlist')->with(['users' => $userData]);
    }

    // admin search
    public function adminSerach(Request $request)
    {
        $response = $this->search('admin', $request);
        Session::put('ADMIN_SEARCH', $request->searchData);
        return view('admin.user.adminlist')->with(['users' => $response]);
    }

    //admin delete
    public function adminDelete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['massage' => 'Admin Data Delete Successful!']);
    }

    // edit Admin get server for update data
    public function editAdmin($id)
    {
        $data = User::where('id', $id)->first();
        return view('admin.user.adminedit')->with(['user' => $data]);
    }

    // update data
    public function updateAdmin($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $this->adminUpdate($request);
        User::where('id', $id)->update($data);
        return back()->with(['massage' => 'Admin data Updated!']);
    }

    //user download
    public function userDownload(Request $request)
    {

        if (Session::has('USER_SEARCH')) {
            $user = User::where('role', 'user')
                ->where(function ($query) use ($request) {
                    $query->orwhere('name', 'like', '%' . Session::get('USER_SEARCH') . '%')
                        ->orwhere('email', 'like', '%' . Session::get('USER_SEARCH') . '%')
                        ->orwhere('phone', 'like', '%' . Session::get('USER_SEARCH') . '%')
                        ->orwhere('address', 'like', '%' . Session::get('USER_SEARCH') . '%');
                })->get();
        } else {
            $user = User::where('role', 'user')->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($user) {
            $user->created_at = $user->created_at->format('Y-m-d');
        });

        $csvExporter->build($user, [
            'id' => 'No',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'password' => 'Password',
            'role' => 'Role',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'user_list.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    //admin download
    public function adminDownload(Request $request)
    {

        if (Session::has('ADMIN_SEARCH')) {
            $user = User::where('role', 'admin')
                ->where(function ($query) use ($request) {
                    $query->orwhere('name', 'like', '%' . Session::get('ADMIN_SEARCH') . '%')
                        ->orwhere('email', 'like', '%' . Session::get('ADMIN_SEARCH') . '%')
                        ->orwhere('phone', 'like', '%' . Session::get('ADMIN_SEARCH') . '%')
                        ->orwhere('address', 'like', '%' . Session::get('ADMIN_SEARCH') . '%');
                })->get();
        } else {
            $user = User::where('role', 'admin')->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($user) {
            $user->created_at = $user->created_at->format('Y-m-d');
        });

        $csvExporter->build($user, [
            'id' => 'No',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'password' => 'Password',
            'role' => 'Role',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'admin_list.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    //data searching
    private function search($role, $request)
    {
        $data = User::where('role', $role)
            ->where(function ($query) use ($request) {
                $query->orwhere('name', 'like', '%' . $request->searchData . '%')
                    ->orwhere('email', 'like', '%' . $request->searchData . '%')
                    ->orwhere('phone', 'like', '%' . $request->searchData . '%')
                    ->orwhere('address', 'like', '%' . $request->searchData . '%');
            })->paginate(7);
        $data->appends($request->all());
        return $data;
    }

    private function adminUpdate($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ];
    }
}

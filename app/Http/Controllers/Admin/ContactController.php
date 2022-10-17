<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contactCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $this->requestUserData($request);
        Contact::create($data);
        return back()->with(['massage' => 'Send Success!']);
    }

    // admin contact list page
    public function contactList()
    {
        if (Session::has('CONTACT_SEARCH')) {
            Session::forget('CONTACT_SEARCH');
        }
        $data = Contact::OrderBy('contact_id', 'desc')->paginate(7);
        if (count($data) == 0) {
            $emptystatus = 0;
        } else {
            $emptystatus = 1;
        }
        return view('admin.contact.list')->with(['contact' => $data, 'status' => $emptystatus]);
    }
    // search contact
    public function searchContact(Request $request)
    {
        $searchData = Contact::orWhere('name', 'like', '%' . $request->searchData . '%')
            ->orWhere('email', 'like', '%' . $request->searchData . '%')
            ->orWhere('message', 'like', '%' . $request->searchData . '%')
            ->paginate(7);

        Session::put('CONTACT_SEARCH', $request->searchData);
        $searchData->appends($request->all());

        if (count($searchData) == 0) {
            $emptystatus = 0;
        } else {
            $emptystatus = 1;
        }
        return view('admin.contact.list')->with(['contact' => $searchData, 'status' => $emptystatus]);
    }
    // contact list download CSV
    public function contactDownload()
    {
        if (Session::has('CONTACT_SEARCH')) {
            $contact = Contact::orWhere('name', 'like', '%' . Session::get('CONTACT_SEARCH') . '%')
                ->orWhere('email', 'like', '%' . Session::get('CONTACT_SEARCH') . '%')
                ->orWhere('message', 'like', '%' . Session::get('CONTACT_SEARCH') . '%')
                ->get();
        } else {
            $contact = Contact::OrderBy('contact_id', 'desc')->get();
        }

        $csvExporter = new \Laracsv\Export();
        $csvExporter->beforeEach(function ($contact) {
            $contact->created_at = $contact->created_at->format('Y-m-d');
        });

        $csvExporter->build($contact, [
            'contact_id' => 'No',
            'user_id' => 'User ID',
            'name' => 'User Name',
            'email' => 'Email',
            'message' => 'Massage',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'contact.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    // request data from client
    private function requestUserData($request)
    {
        return [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CarrierController extends Controller
{
    // direct carrier list page
    public function carrierList()
    {
        if (Session::has('CARRIER_SEARCH')) {
            Session::forget('CARRIER_SEARCH');
        }
        $data = Carrier::paginate(7);
        return view('admin.carrier.carrier')->with(['carriers' => $data]);
    }
    // add carrier page
    public function addCarrier()
    {
        return view('admin.carrier.addCarrier');
    }
    // create carrier
    public function createCarrier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $this->carrierData($request);
        Carrier::create($data);
        return redirect()->route('admin#carrierList')->with(['massage' => '1 row added']);
    }
    // delete carrier
    public function deleteCarrier($id)
    {
        Carrier::where('carrier_id', $id)->delete();
        return back()->with(['massage' => 'Carrier Data Deleted!']);
    }
    // request data from server for update
    public function editCarrier($id)
    {
        $data = Carrier::where('carrier_id', $id)->first();
        return view('admin.carrier.editCarrier')->with(['carrier' => $data]);
    }
    public function updateCarrier(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = $this->carrierData($request);
        Carrier::where('carrier_id', $id)->update($updateData);
        return redirect()->route('admin#carrierList')->with(['massage' => 'Carrier Data Updated!']);
    }
    // search Carrier
    public function searchCarrier(Request $request)
    {
        $key = $request->search;
        $data = Carrier::orWhere('name', 'like', '%' . $key . '%')
            ->orWhere('phone', 'like', '%' . $key . '%')
            ->orWhere('address', 'like', '%' . $key . '%')->paginate(7);
        Session::put('CARRIER_SEARCH', $key);
        $data->append($request->all());
        return view('admin.carrier.carrier')->with(['carriers' => $data]);
    }
    // download carrier list
    public function carrierDownload()
    {
        if (Session::has('CARRIER_SEARCH')) {
            $carrier = Carrier::orWhere('name', 'like', '%' . Session::get('CARRIER_SEARCH') . '%')
                ->orWhere('phone', 'like', '%' . Session::get('CARRIER_SEARCH') . '%')
                ->orWhere('address', 'like', '%' . Session::get('CARRIER_SEARCH') . '%')->get();
        } else {
            $carrier = Carrier::get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($carrier) {
            $carrier->created_at = $carrier->created_at->format('Y-m-d');
        });

        $csvExporter->build($carrier, [
            'carrier_id' => 'ID',
            'name' => 'Name',
            'phone' => 'Product Count',
            'gender' => 'Gender',
            'address' => 'Address',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'carrier_list.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    // request data from client
    private function carrierData($request)
    {
        return [
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ];
    }
}

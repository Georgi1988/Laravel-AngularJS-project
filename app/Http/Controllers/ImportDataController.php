<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;



class ImportDataController extends Controller
{
    public function index()
    {
        $client = new Client(new Version2X('http://localhost:8080', [
            'headers' => [
                'X-My-Header: websocket rocks',
                'Authorization: Bearer 12b3c4d5e6f7g8h9i'
            ]
        ]));

        $client->initialize();
        $client->emit('broadcast', ['foo' => 'bar']);
        $client->close();
    }

    public function importDealerFile(Request $request)
    {
        $excel = $request->file('excel');

        if ($excel == null)
            abort(400, "excel entry is null");

        // move file from tmp to storage
        $excel->move(storage_path() . '/app/', $excel->getClientOriginalName());
        $path = storage_path() . '/app/' . $excel->getClientOriginalName();

        Excel::load($path, function($reader) {
            // load all sheet and record
            $results = $reader->all();

            foreach($results as $r) {
                $userDetail = new UserDetail;
                $userDetail->code = $r[0];
                $userDetail->product_id = $r[0];
                $userDetail->passwd = $r[0];
                $userDetail->type = $r[0];
                $userDetail->invalid_end_date = $r[0];
                $userDetail->save();
            }

//          dump($results);
        });

        return json_encode(array("result" => true));
    }

    public function importShopFile(Request $request)
    {
        $excel = $request->file('excel');

        if ($excel == null)
            abort(400, "excel entry is null");

        // move file from tmp to storage
        $excel->move(storage_path() . '/app/', $excel->getClientOriginalName());
        $path = storage_path() . '/app/' . $excel->getClientOriginalName();

        Excel::load($path, function($reader) {
            // load all sheet and record
            $results = $reader->all();

            foreach($results as $r) {
                $userDetail = new UserDetail;
                $userDetail->code = $r[0];
                $userDetail->product_id = $r[0];
                $userDetail->passwd = $r[0];
                $userDetail->type = $r[0];
                $userDetail->invalid_end_date = $r[0];
                $userDetail->save();
            }

//          dump($results);
        });

        return json_encode(array("result" => true));
    }

    public function importUserFile(Request $request)
    {
        $excel = $request->file('excel');

        if ($excel == null)
            abort(400, "excel entry is null");

        // move file from tmp to storage
        $excel->move(storage_path() . '/app/', $excel->getClientOriginalName());
        $path = storage_path() . '/app/' . $excel->getClientOriginalName();

        Excel::load($path, function($reader) {
            // load all sheet and record
            $results = $reader->all();

            foreach($results as $r) {
                $userDetail = new UserDetail;
                $userDetail->code = $r[0];
                $userDetail->product_id = $r[0];
                $userDetail->passwd = $r[0];
                $userDetail->type = $r[0];
                $userDetail->invalid_end_date = $r[0];
                $userDetail->save();
            }

//          dump($results);
        });

        return json_encode(array("result" => true));
    }

    public function importMachineFile(Request $request)
    {
        $excel = $request->file('excel');

        if ($excel == null)
            abort(400, "excel entry is null");

        // move file from tmp to storage
        $excel->move(storage_path() . '/app/', $excel->getClientOriginalName());
        $path = storage_path() . '/app/' . $excel->getClientOriginalName();

        Excel::load($path, function($reader) {
            // load all sheet and record
            $results = $reader->all();

            foreach($results as $r) {
                $userDetail = new UserDetail;
                $userDetail->code = $r[0];
                $userDetail->product_id = $r[0];
                $userDetail->passwd = $r[0];
                $userDetail->type = $r[0];
                $userDetail->invalid_end_date = $r[0];
                $userDetail->save();
            }

//          dump($results);
        });

        return json_encode(array("result" => true));
    }
}

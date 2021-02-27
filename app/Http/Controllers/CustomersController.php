<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    //
    public function getCustomers(Request $request)
    {

        error_log($request);
        return response()->json([
            'ok' => true,
            'request' => $request
        ], 200);

        /* 
$users_pagination = User::paginate($request->pagination_limit);
        if ($users_pagination) {
            return response()->json([
                'ok' => true,
                'users_pagination' => $users_pagination
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'message' => "Serveur Erreur, Veuillez réessayer"
            ], 400);
        }
        */
    }

    public function fillCustomers(Request $request)
    {
        $csvFile = Storage::get('2000_records_missing_data.csv');
        $file_handle = preg_split('/[\n]/', $csvFile);
        $headers = str_getcsv($file_handle[0], ";");
        unset($file_handle[0]);
        $line_of_text = [];
        foreach ($file_handle as $line) {
            $csv_line = str_getcsv($line, ";");
            $customer = [];
            for ($i = 0; $i < count($csv_line); $i++) {
                $customer[$headers[$i]] = $csv_line[$i];
            }
            $customer['status'] = "invalidated";
            $new_customer = Customer::create($customer);
            $line_of_text[] = $new_customer;
        }
        return response()->json([
            'ok' => true,
            "data" => $line_of_text,
            "headers" => $headers,
        ], 200);
    }
}

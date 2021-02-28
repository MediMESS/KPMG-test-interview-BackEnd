<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    //
    public function getCustomers(Request $request)
    {


        $customers_pagination = Customer::paginate($request->pagination_limit);
        if ($customers_pagination) {
            return response()->json([
                'ok' => true,
                'customers_pagination' => $customers_pagination
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'message' => "Serveur Erreur, Veuillez réessayer"
            ], 400);
        }
    }
}

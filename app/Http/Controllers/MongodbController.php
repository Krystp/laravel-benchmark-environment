<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mongodb;
use App\Models\MongodbOrder;
use Illuminate\Database\QueryException;

class MongodbController extends Controller
{
    public function getMongodb($limit = null) {
        $analiza = Mongodb::with('orders');

        if ($limit !== null) {
            $analiza->take($limit);
        }

        $analiza = $analiza->get();

        if ($analiza->count() > 0) {
            return response()->json($analiza, 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'no records found'
            ], 404);
        }
    }

    public function getMongodbById($id) {
        $analiza = Mongodb::with('orders')->find($id);
        if ($analiza) {
            return response()->json($analiza, 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'no such result found'
            ], 404);
        }
    }

    public function createMongodb(Request $request) {
        try {
            $analiza = new Mongodb;
            $analiza->firstName = $request->firstName;
            $analiza->lastName = $request->lastName;
            $analiza->age = $request->age;
            $analiza->phone = $request->phone;
            $analiza->save();

            if ($request->orders && is_array($request->orders)) {
                foreach ($request->orders as $orderData) {
                    $order = new MongodbOrder;
                    $order->analiza_id = $analiza->_id;
                    $order->product = $orderData['product'];
                    $order->amount = $orderData['amount'];
                    $order->save();
                }
            }

            $analiza = Mongodb::with('orders')->find($analiza->_id);

            return response()->json($analiza, 201);
        } catch (QueryException $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function updateMongodb(Request $request, $id) {     
        try {
            $analiza = Mongodb::find($id);
            if (!$analiza) {
                return response()->json(['message' => 'Record not found'], 404);
            }
            $analiza->firstName = $request->firstName;
            $analiza->lastName = $request->lastName;
            $analiza->age = $request->age;
            $analiza->phone = $request->phone;
            $analiza->save();

            MongodbOrder::where('analiza_id', $id)->delete();

            if ($request->orders && is_array($request->orders)) {
                foreach ($request->orders as $orderData) {
                    $order = new MongodbOrder;
                    $order->analiza_id = $analiza->_id;
                    $order->product = $orderData['product'];
                    $order->amount = $orderData['amount'];
                    $order->save();
                }
            }

            $analiza = Mongodb::with('orders')->find($id);

            return response()->json($analiza, 200);
        } catch (QueryException $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function deleteMongodb($id) {
        $analiza = Mongodb::with('orders')->find($id);
        if ($analiza) {
            MongodbOrder::where('analiza_id', $id)->delete();
            $analiza->delete();
            return response()->json($analiza, 200);
        } else {
            return response()->json(['message' => 'No such record found'], 404);
        }
    }
    
}

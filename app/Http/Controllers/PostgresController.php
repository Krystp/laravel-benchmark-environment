<?php

namespace App\Http\Controllers;

use App\Models\Postgres;
use App\Models\PostgresOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostgresController extends Controller
{
    public function getPostgres($limit = null)
    {
        $query = Postgres::with('orders');

        if ($limit !== null) {
            $query->take($limit);
        }

        $analiza = $query->get();

        if ($analiza->count() > 0) {
            return response()->json($analiza, 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No records found'
            ], 404);
        }
    }

    public function getPostgresById($id)
    {
        $analiza = Postgres::with('orders')->find($id);
        if ($analiza) {
            return response()->json($analiza, 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such result found'
            ], 404);
        }
    }

    public function createPostgres(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'required|integer',
            'orders' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $analiza = Postgres::create($request->only('firstname', 'lastname', 'age', 'phone'));

            if ($request->has('orders')) {
                foreach ($request->orders as $orderData) {
                    $analiza->orders()->create($orderData);
                }
            }

            $analiza = Postgres::with('orders')->find($analiza->id);

            return response()->json($analiza, 201);
        }
    }

    public function updatePostgres(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'required|integer',
            'orders' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $analiza = Postgres::find($id);

            if ($analiza) {
                $analiza->update($request->only('firstname', 'lastname', 'age', 'phone'));

                if ($request->has('orders')) {
                    $analiza->orders()->delete();
                    foreach ($request->orders as $orderData) {
                        $analiza->orders()->create($orderData);
                    }
                }

                $analiza = Postgres::with('orders')->find($analiza->id);

                return response()->json($analiza, 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No such result'
                ], 404);
            }
        }
    }

    public function deletePostgres($id)
{
    $analiza = Postgres::with('orders')->find($id);
    if ($analiza) {
        $analiza->orders()->delete();
        $analiza->delete();
        return response()->json($analiza, 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'No such result'
        ], 404);
    }
}

}

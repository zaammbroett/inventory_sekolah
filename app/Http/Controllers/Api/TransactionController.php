<?php

namespace App\Http\Controllers\Api;  // <-- HARUSNYA INI

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        return Transaction::with(['user','item'])->get();
    }

    public function store(Request $request)
    {

        $transaction = Transaction::create([
            'user_id'=>$request->user_id,
            'item_id'=>$request->item_id,
            'borrow_date'=>now(),
            'status'=>'dipinjam'
        ]);

        return response()->json($transaction);

    }

    public function update($id)
    {

        $transaction = Transaction::find($id);

        $transaction->update([
            'return_date'=>now(),
            'status'=>'dikembalikan'
        ]);

        return response()->json($transaction);

    }

    public function destroy($id)
    {
        Transaction::destroy($id);

        return response()->json([
            'message'=>'deleted'
        ]);
    }

}
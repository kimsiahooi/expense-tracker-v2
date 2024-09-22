<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Transactions/Index', [
            'transactions' => $request->user()->transactions()->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->transactions()->create($request->validate([
            'name' => 'required|string',
            'currency' => 'required|min:3|max:3|uppercase',
            'amount' => 'required|numeric|min:0.01',
            'transaction_at' => 'required|date'
        ]));

        return back()->with('message', [
            'title' => 'Succeed!',
            'description' => 'Transaction is created!',
            'variant' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update(
            $request->validate([
                'name' => 'required',
                'currency' => 'required|min:3|max:3|uppercase',
                'amount' => 'required|numeric|min:0.01',
                'transaction_at' => 'required|date'
            ])
        );

        return back()->with('message', [
            'title' => 'Edited!',
            'description' => 'Transaction is edited!',
            'variant' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back()->with('message', [
            'title' => 'Deleted!',
            'description' => 'Transaction is deleted!',
            'variant' => 'success'
        ]);
    }
}

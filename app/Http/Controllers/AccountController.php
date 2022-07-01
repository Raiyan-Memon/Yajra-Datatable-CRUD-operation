<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use DataTables;
use Prophecy\Exception\Doubler\ReturnByReferenceException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // dd('sdf');
            $data = Account::latest()->get();
            return Datatables::of($data)

            //for internal number giving number from 1.
                    // ->addIndexColumn()
                    ->addColumn('action', function($row){

                        // $data = Account::all();
                           $btn = '<button id="show" value="'.$row->id.'"  class="edit btn btn-primary btn-sm">Show</button> <button value="'.$row->id.'"  id="edit" class="edit btn btn-success btn-sm">Edit</button>';
                           $btn .= ' <button class="btn btn-danger btn-sm"  value="'.$row->id.'" id="delete">Delete</button';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return "create is called";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account)
    {
        $data = new Account;
        $data->name = $request->name;
        $data->enrollno = $request->enrollno;
        $data->save();
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $data = Account::find($account->id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $data = Account::find($account->id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $data = Account::find($account->id);
        $data->name = $request->name;
        $data->enrollno = $request->enrollno;
        $data->update();
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $data = Account::find($account->id);
        $data->delete();
        return $data;
    }
}

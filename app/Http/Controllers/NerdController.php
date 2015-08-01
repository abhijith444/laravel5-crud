<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Nerd;

class NerdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get all the nerds
        $nerds = Nerd::all();

        // load the view and pass the nerds
        return view('nerds.index')
            ->with('nerds', $nerds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('nerds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'nerd_level' => 'required|numeric'
        );
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('nerds/create')
                ->withErrors($validator)
                ->withInput($input);
        } else {
            // store
            $nerd = new Nerd;
            $nerd->name       = $input['name'];
            $nerd->email      = $input['email'];
            $nerd->nerd_level = $input['nerd_level'];
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully created nerd!');
            return redirect('nerds');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $nerd = Nerd::find($id);

        // show the view and pass the nerd to it
        return view('nerds.show')
            ->with('nerd', $nerd);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // get the nerd
        $nerd = Nerd::find($id);

        // show the edit form and pass the nerd
        return view('nerds.edit')
            ->with('nerd', $nerd);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'nerd_level' => 'required|numeric'
        );
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('nerds/create')
                ->withErrors($validator)
                ->withInput($input);
        } else {
            // store
            $nerd = Nerd::find($id);
            $nerd->name       = $input['name'];
            $nerd->email      = $input['email'];
            $nerd->nerd_level = $input['nerd_level'];
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully updated nerd!');
            return redirect('nerds');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $nerd = Nerd::find($id);
        $nerd->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the nerd!');
        return redirect('nerds');
    }
}

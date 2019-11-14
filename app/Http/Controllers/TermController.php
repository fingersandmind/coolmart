<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermRequest;
use App\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::orderBy('created_at', 'asc')->get();
        return view('pages.terms.index',compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TermRequest $request)
    {
        $request->validated();

        Term::create($request->except('_token'));

        if($request->action == 'submit')
        {
            return redirect()->route('terms.index')->withSuccess('Created Successfully!');
        }elseif($request->action == 'new')
        {
            return redirect()->route('terms.create')->withSuccess('Created Successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $term)
    {
        return view('pages.terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(TermRequest $request, Term $term)
    {
        $request->validated();

        $term->update($request->except('_token'));

        if($request->action == 'submit')
        {
            return redirect()->route('terms.index')->withSuccess('Updated Successfully!');
        }elseif($request->action == 'continue')
        {
            return redirect()->route('terms.edit', $term->id)->withSuccess('Updated Successfully!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $term->delete();
        return redirect()->route('terms.index')->withSuccess('Deleted Successfully!');
    }
}

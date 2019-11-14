<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::orderBy('created_at', 'asc')->get();
        return view('pages.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        $request->validated();
        
        Faq::create($request->except('_token'));

        if($request->action == 'submit')
        {
            return redirect()->route('faqs.index')->withSuccess('Created Successfully!');
        }elseif($request->action == 'new')
        {
            return redirect()->route('faqs.create')->withSuccess('Created Successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('pages.faqs.edit',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $request->validated();
        $faq->update($request->except('_token'));
        if($request->action == 'submit')
        {
            return redirect()->route('faqs.index')->withSuccess('Created Successfully!');
        }elseif($request->action == 'continue')
        {
            return redirect()->route('faqs.edit',$faq->id)->withSuccess('Created Successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->withSuccess('Deleted successfully!');
    }
}

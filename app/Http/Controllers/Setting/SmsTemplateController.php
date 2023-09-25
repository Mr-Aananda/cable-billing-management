<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = SmsTemplate::paginate($this->paginate);
        // view
        return view('admin.sms.sms-template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sms.sms-template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string'
        ]);

        // insert
        SmsTemplate::create($data);

        // view
        return redirect()->back()->withSuccess('SMS template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the specified resource
        $template = SmsTemplate::findOrFail($id);
        // view
        return view('admin.sms.sms-template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get the specified resource
        $template = SmsTemplate::findOrFail($id);
        // validation
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string'
        ]);

        // update
        $template->update($data);

        // view with message
        return redirect()->route('sms-template.index')->with('success', 'SMS template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get the specified resource
        $template = SmsTemplate::findOrFail($id);
        // view with message and delete
        if ($template->delete()) {
            return redirect()->route('sms-template.index')->withSuccess('SMS template deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete sms template.');
        }
    }
}

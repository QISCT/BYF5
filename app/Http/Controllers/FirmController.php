<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use Illuminate\Http\Request;

/**
 * Class FirmController
 * @package App\Http\Controllers
 * @author Andrew <andrew@quasars.com>
 */
class FirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.firm.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Contracts\View\Factory
     */
    public function show(Firm $firm)
    {
        return view('admin.firm.view')->with(compact('firm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('admin.firm.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Firm::create($request->all());
        return redirect(route('home'))->with("alert", ['type' => 'success', 'msg' => 'Firm Created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Contracts\View\Factory
     */
    public function edit(Firm $firm)
    {
        return view('admin.firm.edit')->with(compact('firm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Firm $firm)
    {
        $firm->update($request->all());
        return redirect(route('home'))->with("alert", ['type' => 'success', 'msg' => 'Firm Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Firm  $firm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Firm $firm)
    {
        $firm->delete();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Firm Deleted']);
    }

    /**
     * Restore the specified soft deleted model.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $id)
    {
        Firm::withTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Firm Restored']);
    }
}

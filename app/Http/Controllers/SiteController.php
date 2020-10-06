<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\Site;
use Illuminate\Http\Request;

/**
 * Class SiteController
 * @package App\Http\Controllers
 * @author Andrew <andrew@quasars.com>
 */
class SiteController extends Controller
{
    static string $RESOURCE_MODEL = Site::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index(Firm $firm)
    {
        return view('admin.site.index')->with(compact('firm'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Contracts\View\Factory
     */
    public function show(Site $site)
    {
        return view('admin.site.view')->with(compact('site'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function create(Firm $firm)
    {
        return view('admin.site.create')->with(compact('firm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Firm $firm, Request $request)
    {
        Site::create($request->all());
        return redirect(route('home'))->with("alert", ['type' => 'success', 'msg' => 'Site Created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Contracts\View\Factory
     */
    public function edit(Site $site)
    {
        return view('admin.site.edit')->with(compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Site $site)
    {
        $site->update($request->all());
        return redirect(route('home'))->with("alert", ['type' => 'success', 'msg' => 'Site Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Site Deleted']);
    }

    /**
     * Restore the specified soft deleted model.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $id)
    {
        Site::withTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Site Restored']);
    }
}

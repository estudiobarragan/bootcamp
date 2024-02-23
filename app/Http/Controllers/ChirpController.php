<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $chirps = Chirp::with('user')->latest()->get();
        return view('chirps.index',compact('chirps'));
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
        // inser into database
        $validated = $request->validate([
            'message'=> ['required', 'min:3', 'max:255'],
        ]);

        auth()->user()->chirps()->create( $validated );

        return to_route('chirps.index')->with('status',__('Chirp created successfully !'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        // inser into database
        $validated = $request->validate([
            'message'=> ['required', 'min:3', 'max:255'],
        ]);

        $chirp->update( $validated );

        return to_route('chirps.index')->with('status',__('Chirp updated successfully !'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();

        return to_route('chirps.index')->with('status',__('Chirp deleted successfully !'));
    }
}

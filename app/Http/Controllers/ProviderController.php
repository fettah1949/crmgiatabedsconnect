<?php

namespace App\Http\Controllers;

use App\Jobs\FetchGiataHotelsJob;
use App\Models\Hotel_new;
use App\Models\Hotel_provider;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Provider = Provider::get();

        // print_r($this->getProperty()) ;die;
        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'Provider'=>$Provider

        ];
        return view('Provider.index')->with($data);
    }

    public function indexproviderhotel()
    {
        $Provider = Hotel_provider::limit(100)->get();

        // print_r($this->getProperty()) ;die;
        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'Provider'=>$Provider

        ];
        return view('Provider_hotel.index')->with($data);
    }

    public function Apiprovider_hotel()
    {
        FetchGiataHotelsJob::dispatch();
        return response()->json(['message' => 'Le job a été lancé avec succès !']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Provider.create') ; 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $provider = new Provider();
    $provider->provider_name = $request['providername'];
    $provider->provider_code = $request['providercode'];
    
    // Sauvegarde dans la base de données
    $provider->save();

    // Redirection avec message de succès
    return redirect()->route('ProviderList.index')
        ->with('success', 'Prvider added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function update(Request $request)
    {
                // Récupérer l'hôtel et mettre à jour les champs
                $hotel = Provider::findOrFail($request->id);
                // die($request->id);
                $hotel->update($request->except(['_token', 'id']));
            
                // Redirection avec un message de succès
                return redirect()->back()->with('success', 'Provider mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

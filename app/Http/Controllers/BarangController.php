<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBarangRequset;
use App\Http\Requests\UpdateBarangRequset;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        Log::info('List Barang', ['response' => $barang]);
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $barang
        ], 200);
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
    public function store(CreateBarangRequset $request)
    {
        $validated = $request->validated();

        // Decode additional_info if it's provided
        if (isset($validated['additional_info'])) {
            $validated['additional_info'] = json_encode(json_decode($validated['additional_info'], true));
        }

        // Handle file upload
        if ($request->hasFile('gambar_barang')) {
            $path = $request->file('gambar_barang')->store('images');
            $validated['gambar_barang'] = $path;
        }

        $validated['created_by'] = 1;
        $validated['updated_by'] = 1;

        $barang = Barang::create($validated);
        Log::info('barang created', ['request' => $validated, 'response' => $barang]);
        return response()->json([
            'status' => true,
            'message' => 'Data Created',
            'data' => $barang
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = Barang::find($id);
        Log::info('Barang details', ['response' => $barang]);
        if ($barang) {
            return response()->json([
                'status' => true,
                'message' => 'Data Di Temukan',
                'data' => $barang
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak ditemukan',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequset $request,  $id)
    {
        $barang = Barang::findOrFail($id);
        $validated = $request->validated();
        dd($request->all());
        Log::info('Request received', ['request' => $request->all()]);

        // Decode additional_info if it's provided
        if (isset($validated['additional_info'])) {
            $validated['additional_info'] = json_encode(json_decode($validated['additional_info'], true));
        }

        // Handle file upload
        if ($request->hasFile('gambar_barang')) {
            $path = $request->file('gambar_barang')->store('images');
            $validated['gambar_barang'] = $path;
        }

        $validated['updated_by'] = 1;

        // Debug before update
        Log::debug('Data before update', ['barang' => $barang->toArray()]);
        Log::debug('Validated data', ['data' => $validated]);

        Barang::where('id', $id)->update($validated);

        // Debug after update
        Log::debug('Data after update', ['barang' => $barang->toArray()]);

        Log::info('barang updated', ['request' => $validated, 'response' => $barang]);
        return response()->json([
            'status' => true,
            'message' => 'Data Updated',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        Log::info('Data deleted', ['id' => $id]);
        return response()->json(['message' => 'Data deleted successfully']);
    }
}

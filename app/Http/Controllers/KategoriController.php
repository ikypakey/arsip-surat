<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Contracts\View\View as ViewFactory;


class KategoriController extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function index()
    {
        $kategori = Kategori::paginate(4);
        return view('kategori.index', [
            'kategoris' => $kategori
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedata = $request->validate([
            'category_name' => 'required',
            'details' => 'required',
        ]);
        Kategori::create($validatedata);
        Alert::success('Sukses', 'Data Berhasil Ditambah');
        return redirect()->route('kategori.index');
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
        //
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
        $validatedData = $request->validate([
            'category_name' => 'required',
            'details' => 'required',
        ]);
        // cari data task berdasarkan id
        Kategori::find($id)->update($validatedData);

        Alert::success('Sukses', 'Data Berhasil Diperbarui');
        return redirect()->route('kategori.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *s
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $target = Kategori::where('id', $id)->first();
        $target->delete();
        return redirect()->route('kategori.index');
    }
}

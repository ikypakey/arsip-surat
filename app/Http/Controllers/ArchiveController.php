<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all();
        $archive = Archive::paginate(4);
        return view('arsip.index', [
            'archives' => $archive,
            'kategori' => $kategori
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
     * @param  \App\Http\Requests\StoreArchiveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArchiveRequest $request)
    {
        $data = $request->validated();
        $data['file'] = $request->file('file')->store('arsip', 'public');
        Archive::create($data);
        Alert::success('Sukses', 'Data Berhasil Ditambah');
        return redirect()->route('archive.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(Archive $archive)
    {
        $kategori = Kategori::paginate(4);
        return view('arsip.show', [
            'archive' => $archive,
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function edit(Archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArchiveRequest  $request
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArchiveRequest $request, Archive $archive)
    {
        $data = $request->validated();
        if ($request->file('file')) {
            Storage::delete($archive->file);
            $data['file'] = $request->file('file')->store('arsip', 'public');
        }
        $archive->update($data);
        Alert::success('Sukses', 'Data Berhasil Diubah');
        return redirect()->route('archive.show', $archive->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        Storage::delete($archive->file);
        $archive->delete();
        Alert::success('Sukses', 'Data Berhasil Dihapus');
        return redirect()->route('archive.index');
    }

    public function download(Archive $archive)
    {
        return Storage::download($archive->file);
    }
}

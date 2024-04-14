<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::orderBy('id', 'desc')->get();

        return $this->responseFormat($publications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:2|max:150',
            'desc' => 'required|string|min:2|max:250',
            'open' => 'required|boolean',
            'type' => 'required|in:activity,notice',
        ]);

        $publication = Publication::create($validated);

        $publication->users()->attach($request->user()->id);

        // TODO FILES

        return $this->responseFormat($publication, 'Elemento creado éxitosamente', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        return $this->responseFormat($publication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title' => 'string|min:2|max:150',
            'desc' => 'string|min:2|max:250',
            'open' => 'boolean',
            'type' => 'in:activity,notice',
        ]);

        if ($publication->isDirty())
            $publication->update($validated);

        return $this->responseFormat($publication, 'Elemento creado éxitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        if ($publication->trashed())
            $this->responseFormat(true, 'Elemento eliminado éxitosamente');

        $this->responseFormat(null, 'Ocurrio un error, vuelva a intentarlo nuevamente', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function seen(Request $request, Publication $publication)
    {
        $validate = $request->validate([
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        $publication->users()
            ->sync([
                $request->user()->id => ['seen_date' => now()]
            ]);
    }
}

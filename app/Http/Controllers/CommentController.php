<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('id', 'desc')->get();

        return $this->responseFormat($comments);
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
            'desc' => 'required|string|min:2|max:250',
            'publication_id' => 'required|numeric|exists:publications,id',
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        $comment = Comment::create($validated);

        $this->responseFormat($comment, 'Elemento almacenado éxitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return $this->responseFormat($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'desc' => 'string|min:2|max:250',
        ]);

        $comment->update($validated);

        $this->responseFormat($comment, 'Elemento modificado éxitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->delete)
            return $this->responseFormat(true, 'Elemento eliminado éxitosamente');

        return $this->responseFormat(false, 'Ocurrio un error, vuelva a intentarlo nuevamente');
    }
}

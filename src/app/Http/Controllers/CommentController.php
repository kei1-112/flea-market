<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommentRequest;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function store(CommentRequest $request){
        $comment = $request->except('_token');
        Comment::create($comment);
        return redirect('/item:' . $comment['item_id']);
    }
}

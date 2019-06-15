<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Comment as CommentRequest;
use App\Http\Resources\Comment as CommentJson;
use App\Events\CommentEvent;
class CommentController extends Controller
{

    private $type;

    function __construct()
    {
        $this->type['ee'] = 'App\Episode';
        $this->type['gr'] = 'App\Group';
    }


    public function index(Request $request)
    {
        $comments = Comment::where([['commenttable_id',$request->id], ['commenttable_type', $this->type[$request->type]  ]])->get();
        return CommentJson::collection($comments);
    }

    public function commentsForEpisode($id){
        return CommentJson::collection(Comment::find($id)->commenttable);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        // 'user_id','body', 'commentable_id', 'commentable_type'
        $request->validated();
        $comment = new Comment;
        $comment->name = $request->name;
        $comment->body = $request->body;
        $comment->user_id = $request->user_id?$request->user_id:0;
        $comment->commenttable_id = $request->id;
        $comment->commenttable_type = $this->type[$request->type] ;
        $result = $comment->save();
        $data = ['id'=>$comment->commenttable_id,'name'=> $comment->name,'content'=> $comment->body];
        broadcast(new CommentEvent($data));
        return $this->handlerResult($comment->save());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->body = $request->body;
        return $this->handlerResult($comment->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        $comment = Comment::destroy($comment_id);
        return $this->handlerResult($comment);
    }
}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Article Display Section -->
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h3>Show Article</h3>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>{{ $article->title }}</h3>
                    <hr>
                    {!! $article->content !!}
                </div>
            </div>

            <!-- Comment Submission Form -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3>Comment</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('comment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <div class="mb-3">
                            <label for="comment">Send Comment</label>
                            <textarea name="comment" class="form-control"></textarea>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>  
                </div>                   
            </div>

            <!-- Display Comments -->
            @if($article->comments && $article->comments->count() > 0)
                @foreach ($article->comments as $comment)
                    @if ($comment->comment_id == null) <!-- Top-level comment -->
                        <div class="card mb-3">
                            <div class="card-header">
                                {{ $comment->user->name }}
                            </div>
                            <div class="card-body">
                                {{ $comment->comment }}
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">{{ $comment->created_at }}</div>
                                    <div class="col d-flex justify-content-end">
                                        <!-- Reply Button with Modal Trigger -->
                                        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#replyComment{{ $comment->id }}">Reply</a>
                                        
                                        <!-- Delete Button with Modal Trigger -->
                                        <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteComment{{ $comment->id }}">Delete</button>

                                        <!-- Reply Modal -->
                                        <div class="modal fade" id="replyComment{{ $comment->id }}" tabindex="-1" aria-labelledby="replyCommentLabel{{ $comment->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                       <h1 class="modal-title fs-5" id="replyCommentLabel{{ $comment->id }}">Reply Comment</h1>
                                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('comment.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                            <label for="reply{{ $comment->id }}">Reply Comment</label>
                                                            <textarea name="comment" class="form-control" id="reply{{ $comment->id }}" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form> 
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Reply Modal -->

                                        <!-- Delete Confirmation Modal for Comment -->
                                        <div class="modal fade" id="deleteComment{{ $comment->id }}" tabindex="-1" aria-labelledby="deleteCommentLabel{{ $comment->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteCommentLabel{{ $comment->id }}">Delete Comment</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this comment?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Delete Modal for Comment -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Display Replies to the Comment -->
                        @foreach ($comment->comments as $reply)
                            <div class="card mb-3 ms-5"> <!-- Increased margin for better indentation -->
                                <div class="card-header">
                                    {{ $reply->user->name }}
                                </div>
                                <div class="card-body">
                                    {{ $reply->comment }}
                                </div>
                                <div class="card-footer">
                                    <small>{{ $reply->created_at }}</small>

                                    <!-- Delete Button for Reply -->
                                    <button type="button" class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#deleteReply{{ $reply->id }}">Delete</button>

                                    <!-- Delete Confirmation Modal for Reply -->
                                    <div class="modal fade" id="deleteReply{{ $reply->id }}" tabindex="-1" aria-labelledby="deleteReplyLabel{{ $reply->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteReplyLabel{{ $reply->id }}">Delete Reply</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this reply?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('comment.destroy', $reply->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Delete Modal for Reply -->
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @else
                <p>No comments yet.</p>
            @endif

        </div>
    </div>
</div>
@endsection
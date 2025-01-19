@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <h3>Articles</h3>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a href="{{ route('admin.create') }}" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($articles as $article )
                        <div class="card">
                            <div class="card-header">
                                {{ $article->title }}
                            </div>
                            <div class="card-body">
                                <a href="{{ route('admin.show', $article->id) }}">Read More</a>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('admin.edit', $article->id) }}" class="btn btn-secondary">Edit</a>
                                
                                <form action="{{ route('admin.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">DELETE</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

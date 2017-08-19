@extends('layouts.master')

@section('title')
    Trending quotes
@endsection

@section('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')

    @if(!empty( Request::segment(1)))
        <div class="filter-bar">
            A filter has been set! <a href="{{ route('index') }}">Show all quotes</a>
        </div>
    @endif
    @if( count($errors) > 0)
        <section class="info-box fail">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </section>
    @endif

    @if(Session::has('success'))
        <section class="info-box success">
            {{ Session::get('success') }}
        </section>
    @endif
    <section class="quotes">
        <h1>Latest Quotes</h1>
        @for($i=0; $i<count($quotes); $i++)
            <article class="quote{{ $i % 3 === 0 ? ' first-in-line' : ($i+1)%3 === 0 ? ' last-in-line' : '' }}">
                <div class="delete"><a href="{{ route('delete', ['quote_id' => $quotes[$i]->id]) }}">x</a></div>
                {{ $quotes[$i]->quote }}
                <div class="info">Created by <a href="{{ route('index', ['author' => $quotes[$i]->author->name]) }}">{{ $quotes[$i]->author->name }}</a> created on {{ $quotes[$i]->created_at }}</div>
            </article>
        @endfor
        <div class="pagination">
            Pagination
        </div>

    </section>
    <section class="edit-quote">
        <h1>Add a Quote</h1>

        <form action="{{ route('create') }}" method="post">
            <div class="input-group">
                <label for="author">Your Name</label>
                <input type="text" name="author" id="author" placeholder="Your Name"/>
            </div>
            <div class="input-group">
                <label for="quote">Your Quote</label>
                <textarea name="quote" id="quote" rows="5" placeholder="Your Quote"></textarea>
            </div>
            <button type="submit" class="btn">Submit Quote</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </section>
@endsection
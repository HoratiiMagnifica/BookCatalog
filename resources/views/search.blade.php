<!-- resources/views/search_results.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Результаты поиска</h1>

    @if($books->isEmpty())
        <p>Нет результатов для вашего запроса.</p>
    @else
        <ul>
            @foreach($books as $book)
                <li>{{ $book->title }}</li>
            @endforeach
        </ul>
    @endif
@endsection

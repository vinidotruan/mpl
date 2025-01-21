@extends('layouts.app')
@section('content')
    <div class="row">
    @foreach ($books as $item)
    <div class="col-3">
        <a href="{{ asset('storage/books/'.$item->file)}}" target="_blank">
            <div class="card">
                <div class="card-body d-flex justify-content-center align-items-center flex-column">
                    <img
                    src="{{ asset('storage/covers/'.$item->cover) }}"
                    style="max-width: 8vw;"
                    >
                    <p class="mt-2 text-center">
                    {{ $item->name }}
                    </p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
    </div>
@endsection

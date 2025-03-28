@extends('layouts.app')

@section('content')
  <style>
    :root {
      --color-primero: #24acdc;
      --color-segundo: #76c3e4;
      --color-tercero: #c3d3da;
      --color-cuarto: #7f7f7f;
      --color-quinto: #6c6c6c;
      --color-sexto: #5c5c5c;
    }
    .image{
      width: 15rem; 
      height: 15rem;
    }
    .equipo{
      color: var(--color-sexto);
        }
  </style>
  <div class="container">
    <div class="row">
      <div class="offset-3 col-6 text-center">
        <h1>Oh, oh, ha ocurrido un error</h1>
      </div>
      <div class="offset-2 col-8 text-center">
        <img class="rounded mx-auto d-block image" src="img/cross.png" alt="error">
      </div>
      <div class="col-12 text-center">
        <p>Lo sentimos... {{$message}}.</p>
      </div>
      <div class="offset-9 col-3 equipo">
        <p>— 2FA</p>
      </div>
    </div>
  </div>
  @endsection

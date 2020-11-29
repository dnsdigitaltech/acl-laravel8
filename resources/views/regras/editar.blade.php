@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <a class="text-success" href="{{ 'user.index' }}">&leftarrow; Voltar para a listagem</a>

                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger mt-4" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <form action="{{ route('user.update', ['user' => $usuario->id]) }}" method="post" class="mt-4" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" class="form-control" id="name" placeholder="Insira o nome completo"
                                       name="name" value="{{ old('name') ?? $usuario->name }}">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" placeholder="Insira o email Válido"
                                       name="email" value="{{ old('email') ?? $usuario->email }}">
                            </div>

                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" id="password" placeholder="Insira a senha"
                                       name="password" value="{{ old('password') }}">
                            </div>

                            <button type="submit" class="btn btn-block btn-success">Editar Usuário</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a class="text-success" href="{{ route('permission.create') }}">&plus; Cadastrar Permissão</a>

                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger mt-4" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($permissoes as $permissao)
                                <tr>
                                    <td>{{ $permissao->id }}</td>
                                    <td>{{ $permissao->name }}</td>
                                    <td class="d-flex">
                                        <a class="mr-3 btn btn-sm btn-outline-success" href="{{ route('permission.edit', ['permission' => $permissao->id]) }}">Editar</a>
                                        <form action="{{ route('permission.destroy', ['permission' => $permissao->id]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input class="btn btn-sm btn-outline-danger" type="submit" value="Remover">
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

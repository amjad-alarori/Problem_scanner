@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <a class="text-decoration-none" href="/scan">
                    <div class="counter bg-primary">
                        <p>
                            <i class="fas fa-tasks"></i>
                        </p>
                        <h3>Scans</h3>
                        <p class="mb-0">{{\App\Models\Scan::count()}}</p>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a class="text-decoration-none" href="/admin/questions">
                    <div class="counter bg-warning">
                        <p>
                            <i class="fas fa-spinner"></i>
                        </p>
                        <h3>Questions</h3>
                        <p class="mb-0">{{\App\Models\Questions::count()}}</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6">
                <a class="text-decoration-none" href="/admin/categories">
                    <div class="counter bg-success">
                        <p>
                            <i class="fas fa-check-circle"></i>
                        </p>
                        <h3>Categories</h3>
                        <p class="mb-0">{{\App\Models\Categories::count()}}</p>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a class="text-decoration-none" href="/admin/user">
                    <div class="counter bg-danger">
                        <p>
                            <i class="fas fa-bug"></i>
                        </p>
                        <h3>Users</h3>
                        <p class="mb-0">{{\App\Models\User::count()}}</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-8 col-m-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Latest scans
                    </div>
                    <div class="card-content p-4">
                        <table class="w-100">
                            <thead>
                            <tr>
                                <th>Scan name</th>
                                <th>Made by</th>
                                <th class="text-right">Done on</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td>
                                        <a href="{{route('export.show', ['export'=>$result->id])}}">{{$result->scan}}</a>
                                    </td>
                                    <td>{{$result->name}}</td>
                                    <td class="text-right">{{$result->created_at}}</td>
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

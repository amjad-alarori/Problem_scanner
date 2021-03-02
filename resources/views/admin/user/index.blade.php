@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">Users</div>
                <div class="container">
                    <div class="card-body" style="width:100%;">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i =0;@endphp
                            <tr>
                                <form action="{{route('user.store')}}" method="post">
                                    @csrf
                                    <td>
                                        <label>
                                            <input type="text" name="name" class="form-control" required>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="email" name="email" class="form-control" required>
                                        </label>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <label>
                                            <select name="role" class="form-control">@foreach($roles as $role)

                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach</select>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </label>
                                    </td>
                                </form>
                            </tr>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if(Cache::has('user-is-online-' . $user->id))
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-secondary">Offline</span>
                                        @endif
                                    </td>
                                    <td>

                                        <form id="changeForm{{$i}}" action="{{route('user.update',$user)}}"
                                              method="post">
                                            @method('PUT')
                                            @csrf
                                            <select name="role" class="form-control">@foreach($roles as $role)
                                                    @foreach($user->roles as $userrole)
                                                        <option class="form-control-item" value="{{$role->id}}"
                                                                @if($userrole->name == $role->name) selected @endif>{{$role->name}}</option>
                                                    @endforeach
                                                @endforeach</select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6">
                                                <button onclick="submitform({{$i}})" class="btn btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <form action="{{route('user.destroy',$user)}}" method="post">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php $i++@endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="margin:0 auto; display: block;">
                    {{ $users->links("pagination::bootstrap-4") }}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submitform(id) {
            $('#changeForm' + id).submit();
        }

    </script>
@endpush

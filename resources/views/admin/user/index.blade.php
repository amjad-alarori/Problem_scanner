@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-between">
            <h1>Users</h1>
            <div>
                <a type="button" class="btn btn-sm btn-info d-block" data-toggle="modal"
                   data-target="#exampleModal"><i
                        class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create user</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('user.store')}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email / Gebruikersnaam</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label id="LinkLabel">Role</label>
                                <select id="roleSelect" name="role" class="form-control" onchange="setNameOptions();">
                                    @foreach($roles as $role)
                                        <option value="{{$role->slug}}|{{$role->level}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group linkedTd" style="display: none">
                                <label>Linked to</label>
                                <select id="linkSelect" name="link" class="form-control">
                                    <option id="roleSelectDefault" class="form-control-item" value="null"
                                            disabled>--=Select an option=--
                                    </option>
                                    @foreach($allUsers as $user)
                                        <option
                                            class="LinkOptionGroup{{$user->roles[0]->level}} LinkOption form-control-item"
                                            value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <form action="/admin/user" method="get">
                    <div class="row">
                        <div class="col-4">
                            <select name="role" class="form-control float-left">
                                <option value="all">All Roles</option>
                                @foreach($roles as $role)
                                    <option @if(\request()->get('role') == strtolower($role->name)) selected
                                            @endif value="{{$role->slug}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="verified" class="form-control float-left">
                                <option @if(\request()->get('verified') == 'all') selected @endif value="all">Verified
                                    or not
                                </option>
                                <option @if(\request()->get('verified') == 'verified') selected @endif value="verified">
                                    Verified only
                                </option>
                                <option @if(\request()->get('verified') == 'not_verified') selected
                                        @endif value="not_verified">Not verified
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <x-lang-dropdown value="{{\request()->get('language')}}" name="language" all="true"/>
                        </div>
                        <div class="col-1 text-center">
                            <button class="btn btn-orange">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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
                        <th>Email / Gebruikersnaam</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i =0;@endphp
                    <tr>

                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}
                                @if($user->Verified())
                                    <small data-tooltip="tooltip" data-placement="top" class="cursor-help float-right"
                                           data-title="Verified"><i
                                            class="fa fa-check text-success"></i></small>
                                @endif
                            </td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if(Cache::has('user-is-online-' . $user->id))
                                    <span class="text-success">Online</span>
                                @else
                                    <span class="text-secondary">Offline</span>
                                @endif
                            </td>
                            <td>
                                {{$user->roles[0]->name}}
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <form action="{{route('user.show',$user->id)}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{route('user.destroy',$user)}}" method="post">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
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
            <div class="card-footer">
                <div class="float-right">
                    {{ $users->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('[data-tooltip="tooltip"]').tooltip()

        function submitform(id) {
            $('#changeForm' + id).submit();
        }

    </script>
    <script>
        function setNameOptions() {
            var linkLabel = document.getElementById("LinkLabel")
            var users = Array.from(document.getElementsByClassName("LinkOption"))
            var linkedTd = Array.from(document.getElementsByClassName("linkedTd"))
            var role = document.getElementById("roleSelect")
            var link = document.getElementById("linkSelect")
            console.log(role.value)
            link.value = "null"
            if (role.value.split("|")[1] == "1") {
                linkLabel.style.display = "block"
                linkedTd.forEach(function(element) {
                    element.style.display = "block"
                })
                users.forEach(function(element) {
                    if (element.className.includes("LinkOptionGroup2") || element.className.includes("LinkOptionGroup3")) {
                        element.style.display = "block";
                    } else {
                        element.style.display = "none";
                    }
                })
            } else if (role.value.split("|")[1] == "2" || role.value.split("|")[1] == "3") {
                linkLabel.style.display = "block"
                linkedTd.forEach(function(element) {
                    element.style.display = "block"
                })
                users.forEach(function(element) {
                    if (element.className.includes("LinkOptionGroup4")) {
                        element.style.display = "block";
                    } else {
                        element.style.display = "none";
                    }
                })
            } else {
                linkedTd.forEach(function(element) {
                    element.style.display = "none"
                })
                users.forEach(function(element) {
                    LinkLabel.style.display = "none"
                    element.style.display = "none"
                })
            }
        }
    </script>
@endpush



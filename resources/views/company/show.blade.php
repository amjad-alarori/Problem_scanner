@extends('layouts.company')
@section('content')
@php
$level = $user->roles[0]->level;
@endphp
<div class="row justify-content-center pt-5">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">User</div>
            <div class="container">
                <div class="card-body" style="width:100%;">
                    @if($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    @endif

                    <form action="{{route('company.update',$user)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="col-2">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" value="{{$user->name}}">
                        </div>
                        <br>
                        <div class="col-2">
                            <label for="email">Email</label><br>
                            <input id="email" type="text" name="email" value="{{$user->email}}">
                        </div>
                        <br>
                        <div class="col-2">
                            <label for="password">Password</label><br>
                            <input id="password" type="password" placeholder="laat het leeg als je het niet wilt veranderen" name="password">
                            <p>Belangrijk: laat het leeg als je het niet wilt veranderen</p>
                        </div>
                        <br>
                        @if($level == 2 || $level == 3)
                        <div class="col-2">
                            <label for="roleSelect">kies een rol</label>
                            <select id="roleSelect" name="role">
                                @foreach($roles as $role)
                                @if($role->level == 2 || $role->level == 3)
                                <option value="{{$role->slug}}" @if($user->roles[0]->slug == $role->slug) selected="selected" @endif>{{$role->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <br>
                        @endif
                        @if($level == 4)
                        <div class="col-2">
                            <label for="roleSelect">kies een rol</label>
                            <select id="roleSelect" name="role" value="{{$user->roles[0]->slug}}">
                                @foreach($roles as $role)
                                @if($role->level == 4)
                                <option value="{{$role->slug}}" @if($user->roles[0]->slug == $role->slug) selected="selected" @endif>{{$role->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <br>
                        @endif
                        <div class="col-1">
                            <button type="submit" name="id" value="{{$user->id}}"><i class="fa fa-save"></i>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if($level > 0 && $level < 4) <div class="row justify-content-center pt-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">Linked @if($level == 2 || $level == 3) Users @else Consulents @endif</div>
            <div class="container">
                <div class="card-body" style="width:100%;">
                    @if($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    @endif
                    <div>
                        <!-- You can link or unlink the company from an Employee or SuperEmployee -->
                        <form action="{{route('company.link', $user)}}" method="post">
                            @csrf
                            @method("POST")
                            <p>Selecteer een gebruiker om te linken </p>
                            <!-- If the user is an Employee or a SuperEmployee, then it will use the first one -->
                            @if($level == 2 || $level == 3)
                            <select name="clientId" class="form-control">
                                @foreach($users as $x)
                                @if($x->roles[0]->level == 1)
                                <option class="form-control-item" value="{{$x->id}}">{{$x->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <br>
                            <button type="submit" name="employeeId" value="{{$user->id}}"><i class="fa fa-user-plus"></i><br>Link gebruiker</button>
                            @else
                            <select name="employeeId" class="form-control">
                                @foreach($users as $x)
                                @if( $x->roles[0]->level == 2 || $x->roles[0]->level == 3)
                                <option value="{{$x->id}}">{{$x->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <br>
                            <button type="submit" name="clientId" value="{{$user->id}}"><i class="fa fa-user-plus"></i><br>Link gebruiker</button>
                            @endif
                        </form>
                        <br>
                        <br>
                        @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($linkedUsers as $LinkedUser)
                                <tr>
                                    <td>{{$LinkedUser->name}}</td>
                                    <td>{{$LinkedUser->email}}</td>
                                    <td>
                                        @if(Cache::has('user-is-online-' . $LinkedUser->id))
                                        <span class="text-success">Online</span>
                                        @else
                                        <span class="text-secondary">Offline</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route('company.linkDestroy', $user)}}" method="post">
                                            @csrf @method('POST')
                                            <button type="submit" name="otherUser" value="{{$LinkedUser->id}}" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
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
        @endif
    </div>
    </div>
    @endsection
    @push('scripts')
    <script>
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
            link.value = "null"
            if (role.value == "user") {
                linkLabel.style.display = "block"
                linkedTd.forEach(function(element) {
                    element.style.display = "block"
                })
                users.forEach(function(element) {
                    if (element.className.includes("LinkOptionGroupemployee") || element.className.includes(
                            "LinkOptionGrouppoweremployee")) {
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

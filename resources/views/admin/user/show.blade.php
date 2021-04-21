@extends('layouts.admin')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User</div>
                <div class="container">
                    <div class="card-body" style="width:100%;">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                        <form action="{{route('user.update',$user)}}" method="post">
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
                                <input id="password" type="password" placeholder="Leave empty if you don't want to change it" name="password">
                                <p>Important: Leave empty if you don't want to change it</p>
                            </div>
                            <br>
                            @if($user->roles[0]->level == 2 || $user->roles[0]->level == 3)
                                <div class="col-2">
                                    <label for="powerEmployee">PowerEmployee</label>
                                    <input id="powerEmployee" name="powerEmployee" type="checkbox" @if($user->roles[0]->level == 3) checked @endif>
                                </div>
                                <br>
                            @endif
                            <div class="col-1">
                                <button type="submit"><i class="fa fa-save"></i>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @php
                $level = $user->roles[0]->level;
            @endphp
            @if($level > 0 || level < 4)
                <br>
                <br>
                <div class="card">
                    <div class="card-header">Linked @if($level == 2 || $level == 3) users @else Employees @endif</div>
                    <div class="container">
                        <div class="card-body" style="width:100%;">
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                            <div>
                                <form action="{{route("user.link", $user)}}" method="post">
                                    @csrf
                                    @method("POST")
                                    @if($level == 2 || $level == 3)
                                        <select name="clientId" class="form-control">
                                            @foreach($users as $x)
                                                @if($x->roles[0]->level == 1)
                                                    <option class="form-control-item" value="{{$x->id}}">{{$x->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <br>
                                        <button type="submit" name="employeeId" value="{{$user->id}}"><i class="fa fa-user-plus"></i></button>
                                    @else
                                        <select name="employeeId" class="form-control">
                                            @foreach($users as $x)
                                                @if($x->roles[0]->level == 2 || $x->roles[0]->level == 3)
                                                    <option value="{{$x->id}}">{{$x->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <br>
                                        <button type="submit" name="clientId" value="{{$user->id}}"><i class="fa fa-user-plus"></i></button>
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
                                                <form action="{{route('user.linkDestroy', $user)}}" method="post">
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
            console.log(role.value)
            link.value = "null"
            if (role.value == "user") {
                linkLabel.style.display = "block"
                linkedTd.forEach(function(element) {
                    element.style.display = "block"
                })
                users.forEach(function(element) {
                    if (element.className.includes("LinkOptionGroupemployee") || element.className.includes("LinkOptionGrouppoweremployee")) {
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
            // switch (document.getElementById("roleSelect").value) {
            //     case "poweremployee":
            //     case "employee":
            //         LinkLabel.style.display = "block"
            //         linkedTd.forEach(function(element) {
            //             element.style.display = "block"
            //         })
            //         users.forEach(function(element) {
            //             if (element.className.includes("LinkOptionGroupcompany")) {
            //                 element.style.display = "block";
            //             } else {
            //                 element.style.display = "none";
            //             }
            //         })
            //         break
            //     case "user":
            //         LinkLabel.style.display = "block"
            //         linkedTd.forEach(function(element) {
            //             element.style.display = "block"
            //         })
            //         users.forEach(function(element) {
            //             if (element.className.includes("LinkOptionGroupemployee") || element.className.includes("LinkOptionGrouppoweremployee")) {
            //                 element.style.display = "block";
            //             } else {
            //                 element.style.display = "none";
            //             }
            //         })
            //         break
            //     default:
            //         linkedTd.forEach(function(element) {
            //             element.style.display = "none"
            //         })
            //         users.forEach(function(element) {
            //             LinkLabel.style.display = "none"
            //             element.style.display = "none"
            //         })
            // }
        }
    </script>
@endpush

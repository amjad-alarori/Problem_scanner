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
                                <th class="linkedTd" style="display: none">Linked to</th>
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
                                            <select id="roleSelect" name="role" class="form-control" onchange="setNameOptions();">
                                            @foreach($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach</select>
                                        </label>
                                    </td>
                                    <td class="linkedTd" style="display: none">
                                        <label id="LinkLabel">
                                            <select id="linkSelect" name="link" class="form-control">
                                                <option id="roleSelectDefault" class="form-control-item" value="null" disabled>--=Select an option=--</option>
                                                @foreach($allUsers as $user)
                                                    <option class="LinkOptionGroup{{$user->roles[0]->level}} LinkOption form-control-item" value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>
                                            </button>
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
                                        {{$user->roles[0]->name}}
                                    </td>
                                    <td class="linkedTd" style="display: none">
                                        <div class="row">
                                            <div class="col-6">
                                                <form action="{{route('user.show',$user->id)}}" method="get">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-6">
                                                <form action="{{route('user.destroy',$user)}}" method="post">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
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
                    if (element.className.includes("LinkOptionGroup2") || element.className.includes("LinkOptionGroup3")) {
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
            //             if (element.className.includes("LinkOptionGroup4")) {
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
            //             if (element.className.includes("LinkOptionGroup2") || element.className.includes("LinkOptionGroup3")) {
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

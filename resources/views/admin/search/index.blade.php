@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    @php
                        $activee = false;
                    @endphp
                    @if(count($users))
                        <a class="nav-link @if(!$activee) active @endif" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-users"
                           role="tab">Users</a>
                        @php
                            $activee = true;
                        @endphp
                    @endif
                    @if(count($results))
                        <a class="nav-link @if(!$activee) active @endif" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-results"
                           role="tab">Results</a>
                        @php
                            $activee = true;
                        @endphp
                    @endif
                    @if(count($categories))
                        <a class="nav-link @if(!$activee) active @endif" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-categories"
                           role="tab">Categories</a>
                        @php
                            $activee = true;
                        @endphp
                    @endif
                    @if(count($questions))
                        <a class="nav-link @if(!$activee) active @endif" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-questions"
                           role="tab">Questions</a>
                        @php
                            $activee = true;
                        @endphp
                    @endif
                    @if(count($scans))
                        <a class="nav-link @if(!$activee) active @endif" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-scans"
                           role="tab">Scans</a>
                        @php
                            $activee = true;
                        @endphp
                    @endif
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    @php
                        $active = false;
                    @endphp
                    @if(count($users))
                        <div class="tab-pane fade @if(!$active) show active @endif" id="v-pills-users" role="tabpanel">
                            @php
                                $active = true;
                            @endphp
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thread>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                </tr>
                                            </thread>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <a href="{{$user->route}}">{{$user->name}}</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p class="type m-0">{{$user->email}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span>{{$user->roles->first()->name}}</span>
                                                        </div>
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
                    @if(count($results))
                        <div class="tab-pane fade @if(!$active) show active @endif" id="v-pills-results" role="tabpanel">
                            @php
                                $active = true;
                            @endphp
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thread>
                                                <tr>
                                                    <th>Scan name</th>
                                                    <th>Done by</th>
                                                    <th>Created on</th>
                                                </tr>
                                            </thread>
                                            <tbody>
                                            @foreach($results as $result)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <a href="{{$result->route}}">{{$result->scan}}</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span>{{$result->name}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span>{{$result->created_at}}</span>
                                                        </div>
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
                    @if(count($categories))
                        <div class="tab-pane fade @if(!$active) show active @endif" id="v-pills-categories" role="tabpanel">
                            @php
                                $active = true;
                            @endphp
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thread>
                                                <tr>
                                                    <th>Name</th>
                                                </tr>
                                            </thread>
                                            <tbody>
                                            @foreach($categories as $category)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <a href="{{$category->route}}">{{$category->name}}</a>
                                                        </div>
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
                    @if(count($questions))
                        <div class="tab-pane fade @if(!$active) show active @endif" id="v-pills-questions" role="tabpanel">
                            @php
                                $active = true;
                            @endphp
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thread>
                                                <tr>
                                                    <th>Name</th>
                                                </tr>
                                            </thread>
                                            <tbody>
                                            @foreach($questions as $question)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <a href="{{$question->route}}">{{$question->question}}</a>
                                                        </div>
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
                    @if(count($scans))
                        <div class="tab-pane fade @if(!$active) show active @endif" id="v-pills-scans" role="tabpanel">
                            @php
                                $active = true;
                            @endphp
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thread>
                                                <tr>
                                                    <th>Scan name</th>
                                                </tr>
                                            </thread>
                                            <tbody>
                                            @foreach($scans as $scan)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <a href="{{$scan->route}}">{{$scan->name}}</a>
                                                        </div>
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
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @guest
                    <div class="card card-default">
                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Username</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="nav-bar">
                        <div class="n_b_1">
                            <label>Username:</label>
                            <span class="username-item" style="color: indigo">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="n_b_2" style="float: right; margin-top: -3.5%">
                            <a class="logout-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @endguest
                    <table class="table table-bordered">
                        @if (count($announcement) > 0)
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th width="280px">Action</th>
                            </tr>
                        @else
                            @guest
                            @else
                                <span style="color: #c82333;">No ads!</span>
                            @endguest
                        @endif
                        @foreach ($announcement as $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <a class="" href="{{ route('announcement.show',$item->id) }}" style="text-decoration: none; color: black">
                                        {{ $item->title}}
                                    </a>
                                </td>
                                <td>{{ $item->description}}</td>
                                <td>
                                    @if (isset(Auth::user()->name) && ($item->author_name === Auth::user()->name))
                                        <a class="btn btn-primary" href="{{ route('announcement.edit',$item->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['announcement.destroy', $item->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @else
                                        <span style="color: #c82333">no action</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div style="display: inline-block">
                        {!! $announcement->links() !!}
                    </div>
                    @guest
                    @else
                        <div style="float: right; display: inline-block">
                            <div class="pull-right">
                                <a class="btn btn-success" href="{{ route('announcement.create') }}"> Create Ad</a>
                            </div>
                        </div>
                    @endguest
            </div>
        </div>
    </div>
@endsection

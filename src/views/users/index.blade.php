@extends('acl::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <h1>Users administration</h1>
                <div class="form-group">
                    <a href="{{ Acl::route('users','create') }}" class="btn btn-primary">Add User</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="30">ID</th>
                                <th width="150">Name</th>
                                <th>Email</th>
                                <th width="140"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ Acl::route('users','edit', $user->id) }}" class="btn">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ Acl::route('users','show', $user->id) }}" class="btn">
                                            <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                                        </a>
                                        <form name="delete-user" action="{{ Acl::route('users','destroy', $user->id) }}" method="post" style="display: inline">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <a onclick="$(this).closest('form').submit();" class="btn" style="color:red;">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
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
@endsection

@extends('acl::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <h1>Roles administration</h1>
                <div class="form-group">
                    <a href="{{ Acl::route('roles','create') }}" class="btn btn-primary">Add Role</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="30">ID</th>
                                <th width="150">Code</th>
                                <th width="150">Name</th>
                                <th>Description</th>
                                <th width="150"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->code }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <a href="{{ Acl::route('roles','edit', $role->id) }}" class="btn">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ Acl::route('roles','show', $role->id) }}" class="btn">
                                            <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                                        </a>
                                        <form name="delete-role" action="{{ Acl::route('roles','destroy', $role->id) }}" method="post" style="display: inline">
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

@extends('acl::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <h1>{{ isset($user) ? 'Update' : 'Create' }} User</h1>
                <div>
                    <form name="save-user" method="post" action="{{ isset($user) ? Acl::route('users','update',$user)  : Acl::route('users','store') }}">
                        {{ csrf_field() }}
                        {{ isset($user) ? method_field('put') : '' }}
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text"  class="form-control" name="name" value="{{ isset($user) ? $user->name : '' }}" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text"  class="form-control" name="email" value="{{ isset($user) ? $user->email : '' }}" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control" name="password" value="" placeholder="Password">
                        </div>
                        @if (isset($roles))
                        <div class="form-group">
                            <label class="control-label">Roles</label>
                            <select multiple="multiple" name="roles[]" class="form-control">

                                @foreach($roles as $role)
                                    <option
                                            value="{{ $role->id }}"
                                            {{ isset($user) ? in_array($role->id, $user->roles()->lists('id')->toArray()) ? 'selected' : '' : '' }}>{{ $role->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <input type="submit" value="Save" name="submit" class="btn btn-primary pull-right" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        $('select').select2();
    </script>
@endsection
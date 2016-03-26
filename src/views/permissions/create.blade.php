@extends('acl::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <h1>{{ isset($permission) ? 'Update' : 'Create' }} Permission</h1>
                <div>
                    <form name="save-permission" method="post" action="{{ isset($permission) ? route('acl.permissions.update',$permission)  : route('acl.permissions.store') }}">
                        {{ csrf_field() }}
                        {{ isset($permission) ? method_field('put') : '' }}
                        <div class="form-group">
                            <label class="control-label">Code</label>
                            <input type="text"  class="form-control" name="code" value="{{ isset($permission) ? $permission->code : '' }}" placeholder="Code">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text"  class="form-control" name="name" value="{{ isset($permission) ? $permission->name : '' }}" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <input type="text"  class="form-control" name="description" value="{{ isset($permission) ? $permission->description : '' }}" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Save" name="submit" class="btn btn-primary pull-right" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

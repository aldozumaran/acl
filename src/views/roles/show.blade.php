@extends('acl::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <h1>Role Detail</h1>
                <div>
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="150">Section / Perms</th>
                                @foreach($permissions as $permission)
                                <th width="150" class="text-center">{{ $permission->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sections as $s)
                            <tr>
                                <td>{{ $s->name }}</td>
                                @foreach($permissions as $p)
                                <td class="text-center">
                                    <a 
                                        href="#" 
                                        data-form="#change-permission" 
                                        class="acl-change-status {{ $role->hasPermission($s->code,$p->code) ? 'active' : '' }}" 
                                        data-role-id="{{ $role->id }}" 
                                        data-permission-id="{{ $p->id }}" 
                                        data-section-id="{{ $s->id }}"
                                        >
                                        
                                    </a>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form name="change-permission" id="change-permission" method="post" action="{{ Acl::route('roles','read_update') }}">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <input type="hidden" name="role_id" id="role_id" value="0" />
        <input type="hidden" name="permission_id" id="permission_id" value="0" />
        <input type="hidden" name="section_id" id="section_id" value="0" />
    </form>
@endsection

@section('script')
    
@endsection
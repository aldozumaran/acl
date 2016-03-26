<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('vendor/aldozumaran/acl/acl.css')}}" rel="stylesheet" />
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('acl.index') }}">
                    Laravel Acl
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('acl.roles.index') }}">Roles</a></li>
                    <li><a href="{{ route('acl.users.index') }}">Users</a></li>
                    <li><a href="{{ route('acl.sections.index') }}">Sections</a></li>
                    <li><a href="{{ route('acl.permissions.index') }}">Permissions</a></li>
                </ul>

            </div>
        </div>
    </nav>
    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    @yield('script')
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('.acl-change-status').click(function(e) {
                e.preventDefault();
                
                if ($(this).data('clicked'))
                    return false;

                $(this).data('clicked',true);

                var $this = $(this),
                    $form = $($this.data('form'));

                $('#role_id',$form).val($this.data('roleId'));
                $('#user_id',$form).val($this.data('userId'));
                $('#permission_id',$form).val($this.data('permissionId'));
                $('#section_id',$form).val($this.data('sectionId'));

                $.post($form.attr('action'),$form.serializeArray(),function(data){
                    if (data.response)
                        $this.toggleClass('active');

                    $this.data('clicked',false);

                },'json');
            });
        });
    </script>
</body>
</html>

<x-app-web-layout>
    @include('role-permission.nav-links')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Roles
                            <a href="{{ url('roles/create') }}" class="btn btn-primary float-end">Add Role</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ url('roles/' . $role->id . '/give-permissions') }}" class="btn btn-warning">Add / Edit Permissions</a>
                                            
                                            @can('update role')
                                                <a href="{{ url('roles/' . $role->id . '/edit') }}" class="btn btn-success mx-2">Edit</a>
                                            @endcan

                                            @can('delete role')
                                                <a href="{{ url('roles/' . $role->id . '/delete') }}" class="btn btn-danger ">Delete</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-web-layout>

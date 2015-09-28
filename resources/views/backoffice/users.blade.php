@extends('backoffice')

@section('content')

    <div class="bs-example" data-example-id="hoverable-table" id="users">
        <table class="table table-hover users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>{{trans('interface.name')}}</th>
                <th>Email</th>
                <th>Role/s</th>
                <th>{{trans('interface.state')}}</th>
                <th>{{trans('interface.confirmed')}}</th>
                <th></th>

            </tr>
            </thead>

            <tbody>
            <tr v-repeat="user in users">
                <td>@{{user.id}}</td>
                <td>@{{user.name}}</td>
                <td>@{{user.email}}</td>

                <td>
                    <span class="role" v-repeat="role in user.roles">
                        @{{ role.role }}
                    </span>
                </td>

                <td align="center">
                    <span class="fa"
                          v-class="fa-check: user.is_active,
                                   fa-remove: ! user.is_active"
                          v-on="click: toggleUserState(user)"
                    ></span>
                </td>

                <td align="center">
                    <span class="fa"
                          v-class="fa-check: user.confirmed,
                                   fa-remove: ! user.confirmed"
                    ></span>
                </td>

                <td>
                    <button
                        class="btn btn-default fa fa-trash"
                        v-on="click: deleteUser(user)"
                    >
                        {{trans('interface.remove')}}
                    </button>
                </td>
            </tr>

            </tbody>
        </table>
        <pre>@{{$data | json}}</pre>
    </div>
	
@stop
@extends('layouts.dashboard')

@section('content')


    <hr/>

    <div class="container">
        <div class="row col-md-10 custyle">
            <table class="table table-striped custab">
                <thead>
                <a href="{!!   URL::action('UserController@create') !!}" class="btn btn-primary btn-xs pull-right"><b>+</b> @lang('crud.addModel', ['currentModelName' => $currentModelName])</a>
                <tr>
                    <th>ID</th>
                    <th>{{ trans('crud.username') }}</th>
                    <th>{{ trans('crud.email') }}</th>
                    <th>{{ trans('crud.grade') }}</th>
                    <th>{{ trans('crud.picture') }}</th>
                    <th>{{ trans('crud.country') }}</th>
                    <th class="text-center">{{ trans('crud.action') }}</th>
                </tr>
                </thead>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td align="center">{{ $user->grade }}</td>
                        <td>
                            @if (!is_null($user->picture))
                                <img src="{{ URL::to(Config::get('constants.AVATAR_PATH'). $user->picture) }}" class="img-circle img-sm" />
                            @else
                                <img src="{{ URL::to(Config::get('constants.AVATAR_PATH'). "avatar.png") }}" class="img-circle img-sm" />
                            @endif
                        </td>

                        <td>{{ $user->country }}</td>

                        <td class="text-center">
                            <a class='btn btn-info btn-xs' href="{!!   URL::action('UserController@edit',  $user->id) !!}">
                                <span class="glyphicon glyphicon-edit"></span> {{ trans('crud.edit') }}</a>
                            <a class="btn btn-danger btn-xs"
                               href="{!! URL::action('UserController@destroy',  $user->id) !!}" data-method="delete" data-token="{{csrf_token()}}">
                                <span class="glyphicon glyphicon-remove"></span> {{ trans('crud.delete') }}</a>
                        </td>
                    </tr>

                @endforeach

            </table>
        </div>
    </div>

@stop


@extends('layouts.dashboard')
@section('title')
    <title>{{ trans_choice('structures.association',2) }}</title>
@stop

@section('title')

@stop
@section('breadcrumbs')
    {!! Breadcrumbs::render('associations.index') !!}
@stop

@section('content')
    <!-- Submenu -->
    @include('layouts.displayMenuMyEntitiesOnTop')
    <!-- /Submenu -->
    <div class="container-fluid">

        @if (sizeof($associations)==0)
            @include('layouts.noAssociations')
        @else
            <table class="table table-togglable table-hover">
                <thead>
                <tr>
                    <th data-toggle="true">{{ trans_choice('core.name',1) }}</th>
                    <th class="text-center" data-hide="phone">{{ trans_choice('structures.federation',1) }}</th>
                    <th class="text-center" data-hide="all">{{ trans('structures.association.president') }}</th>
                    <th class="text-center" data-hide="all">{{ trans('core.email') }}</th>
                    <th class="text-center" data-hide="all">{{ trans('structures.federation.address') }}</th>
                    <th class="text-center" data-hide="all">{{ trans('structures.association.phone') }}</th>
                    <th class="text-center" data-hide="phone">{{ trans('core.country') }}</th>
                    <th class="text-center" data-hide="phone">{{ trans('core.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($associations as $association)
                    <tr is="association-item"
                        :association="{{  $association }}"
                        :url_base="{{ json_encode(route('api.root')) }}"
                        :url_edit="{{ json_encode(route('associations.edit', $association)) }}"
                        :url_delete="{{ json_encode(route('api.associations.delete', $association)) }}"
                        :url_undo="{{ json_encode(route('api.associations.restore', $association)) }}"
                    >
                        <template slot="name">
                            @if (Auth::user()->isSuperAdmin() || Auth::user()->isFederationPresident())
                                <a href={{ route('associations.edit', $association) }} >{{ $association->name }}</a>
                            @else
                                {{ $association->name }}
                            @endif
                        </template>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @include("errors.list")
@stop
@section('scripts_footer')
    {!! Html::script('js/pages/header/footable.js') !!}
    {!! Html::script('js/associations.js') !!}
@stop

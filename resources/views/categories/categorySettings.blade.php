@section('scripts')
    {!! Html::script('js/jquery.timepicker.js') !!}
    {!! Html::script('js/core/libraries/jquery_ui/sliders.min.js') !!}
    {!! Html::script('js/core/libraries/jquery_ui/touch.min.js') !!}
    {!! Html::script('js/plugins/sliders/slider_pips.min.js') !!}
    {!! Html::script('js/plugins/sliders/nouislider.min.js') !!}
@stop
@section('styles')
    {!! Html::style('js/jquery.timepicker.css')!!}
@stop
<?php
$categoryId = $tournament->categoryTournaments->get($key)->category->id;
?>

@if (is_null($setting))
    {!! Form::open(['url' => 'tournaments/'.$tournament->id.'/categories/'.$categoryId.'/settings']) !!}
@else
    {!! Form::model($setting,
                ['method'=>"PATCH",
                'class' => 'form-pricing',
                 "action" => ["CategorySettingsController@update",
                 $tournament->id,
                 $categoryId,
                 $setting->id]]) !!}

    {!! Form::model($setting, ['method'=>"PATCH",
        "action" => [ "CategorySettingsController@update", $tournament->id, $categoryId,$setting->id]]) !!}
@endif
<div class="tab-pane" id="category">
    <div class="row">
        <div class="col-md-2">
            <div class="checkbox-switch ">
                <label>
                    {!!  Form::label('isTeam', trans('crud.isTeam')) !!} <br/>
                    {!!   Form::hidden('isTeam', 0,['id'=>'isTeam'.$key ]) !!}
                    {!!   Form::checkbox('isTeam', 1, is_null($setting) ? 0 : $setting->isTeam  , ['class' => 'switch', 'data-on-text'=>"Si", 'data-off-text'=>"No", 'id'=>'isTeam'.$key ]) !!}

                </label>
            </div>
        </div>
        <div class="col-md-5">
            {!!  Form::label('teamSize', trans('crud.teamSize')) !!}<br/>
            {!!  Form::select('teamSize', [2,3,4,5,6,7,8,9,10,11,12,13,14,15],old('teamsize'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-5">

            {!!  Form::label('fightDuration', trans('crud.fightDuration')) !!}
            <div class="input-group">
                {!!  Form::input('text','fightDuration',is_null($setting) ? 0 : $setting->fightDuration, ['class' => 'form-control','id' => 'fightDuration'.$key]) !!}
                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="checkbox-switch">
                <label>

                    {!!  Form::label('hasEncho', trans('crud.hasEncho')) !!} <br/>
                    {!!   Form::hidden('hasEncho', 0,['id'=>'isTeam'.$key ]) !!}
                    {!!   Form::checkbox('hasEncho', 1, is_null($setting) ? 0 : $setting->hasEncho,
                                         ['class' => 'switch', 'data-on-text'=>"Si", 'data-off-text'=>"No", 'id'=>'hasEncho'.$key]) !!}

                </label>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                {!!  Form::label('enchoQty', trans('crud.enchoQty')) !!}
                {!!  Form::select('enchoQty', [0,1,2,3,4,5,6,7,8,9,10], old('enchoQty'),['class' => 'form-control']) !!}
                <small class="display-block">0 para infinito</small>
            </div>
        </div>
        <div class="col-md-5">

            {!!  Form::label('enchoDuration', trans('crud.enchoDuration')) !!}
            <div class="input-group ">
                {!!  Form::input('text','enchoDuration', is_null($setting) ? 0 : $setting->enchoDuration, ['class' => 'form-control','id' => 'enchoDuration'.$key]) !!}
                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>


        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="checkbox-switch ">
                <label>

                    {!!  Form::label('hasRoundRobin', trans('crud.hasRoundRobin')) !!} <br/>
                    {!!   Form::hidden('hasRoundRobin', 0,['id'=>'hasRoundRobin'.$key ]) !!}
                    {!!   Form::checkbox('hasRoundRobin', 1, is_null($setting) ? 0 : $setting->hasRoundRobin,
                                         ['class' => 'switch', 'data-on-text'=>"Si", 'data-off-text'=>"No", 'id'=>'hasRoundRobin'.$key]) !!}

                </label>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                {!!  Form::label('roundRobinWinner', trans('crud.roundRobinWinner')) !!}
                {!!  Form::select('roundRobinWinner', [0,1,2,3], old('roundRobinWinner'),['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                {!!  Form::label('cost', trans('crud.cost')) !!}
                {!!  Form::input('number','cost',is_null($setting) ? 0 : $setting->cost, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="checkbox-switch">
                <label>

                    {!!  Form::label('hasHantei', trans('crud.hasHantei')) !!} <br/>
                    {!!   Form::hidden('hasHantei', 0,['id'=>'hasHantei'.$key ]) !!}
                    {!!   Form::checkbox('hasHantei', 1,is_null($setting) ? 0 : $setting->hasHantei,
                                         ['class' => 'switch', 'data-on-text'=>"Si", 'data-off-text'=>"No", 'id'=>'hasHantei'.$key]) !!}

                </label>
            </div>
        </div>
        <div class="col-md-5">
            <div class="">
                {!!  Form::label('fightingAreas', trans('crud.fightingAreas')) !!}
                {!!  Form::select('fightingAreas', [0,1,2,4,8], old('fightingAreas'),['class' => 'form-control']) !!}

            </div>

        </div>
    </div>
    {{--{!!   Form::hidden('tournament_id', $tournamentId) !!}--}}
    {{--{!!   Form::hidden('category_id', $categoryId) !!}--}}


    <div align="right">
        <button type="submit" class="btn btn-success" id="save{{$key}}">{{trans("core.save")}}</button>
    </div>
    <script>

        $(function () {
            $('#fightDuration{{$key}}').timepicker(('option',

            {
                'minTime': '2:00',
                'maxTime': '5:00',
                'timeFormat': 'H:i',
                'step': '15'
            }));

            $('#enchoDuration{{$key}}').timepicker(('option',

            {
                'minTime': '0:00',
                'maxTime': '5:00',
                'timeFormat': 'H:i',
                'step': '15'
            }));

            {{--$(".teamSizeSlider{{$key}}").slider({--}}
                {{--max: 10,--}}
                {{--value: {!! $teamSize !!} ,--}}
                {{--change: function (event, ui) {--}}
                    {{--$('#teamSize{{$key}}').attr('value', ui.value);--}}
                {{--}--}}
            {{--});--}}
            {{--$(".teamSizeSlider{{$key}}").slider("pips");--}}
            {{--$(".teamSizeSlider{{$key}}").slider("float");--}}
            {{--//----------------------------}}

            {{--$(".enchoQtySlider{{$key}}").slider({--}}
                {{--max: 5,--}}
                {{--value: {!! $enchoQty  !!} ,--}}
                {{--change: function (event, ui) {--}}
                    {{--$('#enchoQty{{$key}}').attr('value', ui.value);--}}
                {{--}--}}
            {{--});--}}
            {{--$(".enchoQtySlider{{$key}}").slider("pips");--}}
            {{--$(".enchoQtySlider{{$key}}").slider("float");--}}
            {{--//----------------------------}}

            {{--$(".fightingAreasSlider{{$key}}").slider({--}}
                {{--max: 5,--}}
                {{--value: {!! $fightingAreas !!} ,--}}
                {{--change: function (event, ui) {--}}
                    {{--$('#fightingAreas{{$key}}').attr('value', ui.value);--}}
                {{--}--}}
            {{--});--}}
            {{--$(".fightingAreasSlider{{$key}}").slider("pips");--}}
            {{--$(".fightingAreasSlider{{$key}}").slider("float");--}}

        });
    </script>

</div>
{!! Form::close()!!}
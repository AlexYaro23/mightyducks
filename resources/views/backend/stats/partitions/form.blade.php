<div class="form-group">
    {!! Form::label('game_id', trans('backend.stats.game_id')) !!}
    {!! Form::select('game_id', $gameList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('player_id', trans('backend.stats.player_id')) !!}
    {!! Form::select('player_id', $playerList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('parameter', trans('backend.stats.parameter')) !!}
    {!! Form::select('parameter', $parameterList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('value', trans('backend.stats.value')) !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('team', trans('backend.games.team')) !!}
    {!! Form::text('team', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('date', trans('backend.games.date')) !!}
    {!! Form::text('date', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('score1', trans('backend.games.score1')) !!}
    {!! Form::text('score1', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('score2', trans('backend.games.score2')) !!}
    {!! Form::text('score2', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('home', trans('backend.games.home')) !!}
    {!! Form::select('home', $homeList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('place', trans('backend.games.place')) !!}
    {!! Form::text('place', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', trans('backend.games.status')) !!}
    {!! Form::select('status', $statusList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>
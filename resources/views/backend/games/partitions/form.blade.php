<div class="form-group">
    {!! Form::label('team_id', trans('backend.games.teamA')) !!}
    {!! Form::select('team_id', $teams, null, ['class' => 'form-control']) !!}
</div>

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
    {!! Form::label('round', trans('backend.games.round')) !!}
    {!! Form::text('round', null, ['class' => 'form-control']) !!}
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
    {!! Form::label('tournament_id', trans('backend.games.tournament_id')) !!}
    {!! Form::select('tournament_id', $tournamentList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('mls_id', trans('backend.games.mls_id')) !!}
    {!! Form::text('mls_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('mls_url', trans('backend.games.mls_url')) !!}
    {!! Form::text('mls_url', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('name', trans('backend.tournaments.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('link', trans('backend.tournaments.link')) !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', trans('backend.tournaments.status')) !!}
    {!! Form::select('status', $statusList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('team_id', trans('backend.tournaments.team_id')) !!}
    {!! Form::select('team_id', $teamList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>
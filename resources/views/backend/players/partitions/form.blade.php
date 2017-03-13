<div class="form-group">
    {!! Form::label('user_id', trans('backend.players.user_id')) !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('mls_id', trans('backend.players.mls_id')) !!}
    {!! Form::text('mls_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('team_id', trans('backend.players.team_id')) !!}
    {!! Form::select('team_id', $teams, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('name', trans('backend.players.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('date_of_birth', trans('backend.players.date_of_birth')) !!}
    {!! Form::text('date_of_birth', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('position', trans('backend.players.position')) !!}
    {!! Form::text('position', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', trans('backend.players.status')) !!}
    {!! Form::select('status', $statuses, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('tournaments', trans('backend.players.tournaments')) !!}
    {!! Form::select ('tournaments[]', $tournaments, $selectedTournaments, ['id' => 'tournaments', 'class' => 'form-control', 'multiple' => 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>

@section('footer')
    <script>
        $(function(){
            $('#tournaments').select2();
        });
    </script>
@endsection
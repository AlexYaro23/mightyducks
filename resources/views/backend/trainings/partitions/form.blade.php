<div class="form-group">
    {!! Form::label('name', trans('backend.trainings.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('address', trans('backend.trainings.address')) !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('day_of_week', trans('backend.trainings.day_of_week')) !!}
    {!! Form::select('day_of_week', $dayList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('time', trans('backend.trainings.time')) !!}
    {!! Form::text('time', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', trans('backend.trainings.status')) !!}
    {!! Form::select('status', $statusList,null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>
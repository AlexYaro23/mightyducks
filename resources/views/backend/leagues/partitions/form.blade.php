<div class="form-group">
    {!! Form::label('name', trans('backend.leagues.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('link', trans('backend.leagues.link')) !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', trans('backend.leagues.status')) !!}
    {!! Form::select('status', $statusList, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('info', trans('backend.leagues.info')) !!}
    {!! Form::textarea('info', null,['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('logo', trans('backend.leagues.logo')) !!}
    {!! Form::file('logo', ['class' => 'form-control']) !!}
    @if(isset($league) && $league->hasLogo())
        <img src="{{ $league->getLogoLink() }}" width="50px">
    @endif
</div>

<div class="form-group">
    {!! Form::submit(trans('general.update'), ['class' => 'btn btn-info form-control']) !!}
</div>
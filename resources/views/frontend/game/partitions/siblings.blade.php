<div class="col-md-3">
    <div class="pull-left">
        @if(isset($siblings['prev']->id))
            <a href="{{ route('game.visit', ['id' => $siblings['prev']->id]) }}">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>
<div class="col-md-6 text-center">
    {{ trans('frontend.game.move_to_sibling') }}
</div>
<div class="col-md-3">
    <div class="pull-right">
        @if(isset($siblings['next']->id))
            <a href="{{ route('game.visit', ['id' => $siblings['next']->id]) }}">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>
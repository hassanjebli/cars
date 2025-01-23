@props(['color','bgColor'=>'white'])



<div {{$attributes->merge(['lang'=>'Ma'])->class("card card-text-$color card-bg-$bgColor habibi")}}>
    <div class="card-header">{{$title}}</div>
    @if ($slot->isEmpty())
        Hassan Habibi
    @else
        {{$slot}}
    @endif

    <div class="card-footer">{{$footer}}</div>
</div>

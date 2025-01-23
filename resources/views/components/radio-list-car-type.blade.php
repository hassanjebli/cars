<div class="row">
    <div class="col">
        @foreach ($types as $type)
            <label class="inline-radio" style="margin:10px 0px">
                <input type="radio" name="car_type_id" value="{{ $type->id }}" />
                {{ $type->name }}
            </label>

            @if ($loop->iteration % 6 == 0 && !$loop->last)
    </div>
    <div class="col">
        @endif
        @endforeach
    </div>
</div>

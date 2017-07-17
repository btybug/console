<div class="row">
    @if(count($data))
        @foreach($data as $table => $columns)
            <h3>Table {!! $table !!}</h3>
            @if(count($columns))
                @foreach($columns as $key => $value)
                    <p><b>{!! $key !!} :</b> {!! $value !!}</p>
                @endforeach
            @endif
        @endforeach
    @else
        <p>No Entry</p>
    @endif
</div>
<div style=" min-height: 500px;padding:10px">
    <ul class="formlisting">
        @if($variations)
            @foreach($variations as $variation)
                <li>
                    <a href="javascript:void(0)" class="btn text-center item m-item" data-btnrole="getvariation"
                       data-type="{!! $unit->type !!}" data-value="{!! $variation->id !!}">
                        <input type="hidden" data-action="main_body_modality" data-value="{!! $variation->id !!}"><img
                                src="/resources/assets/images/form-list2.jpg"></a>
                    <span>{!! $variation->title !!}</span>
                </li>
            @endforeach
        @endif
    </ul>
</div>
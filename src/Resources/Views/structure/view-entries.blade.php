@extends('btybug::layouts.admin')
@section('content')
    <div class="row m-b-10">
        <h3>Entry details</h3>

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>IP</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="field_list">
                @if(count($data))
                    @foreach($data as $count => $entry)
                        <tr class="field-row">
                            <td>{!! $entry['user_info']['ip'] !!}</td>
                            <td>{!! BBgetDateFormat($entry['user_info']['created_at']) !!}
                                - {!! BBgetTimeFormat($entry['user_info']['created_at']) !!}</td>
                            <td>
                                <a href="javascript:void(0)" data-count="{!! $count !!}" data-id="{!! $id !!}"
                                   class="btn btn-success show-entry-data"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">
                            No entries
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="entry_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Data</h4>
                </div>
                <div class="modal-body entry-content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('resources::assests.magicModal')
@stop
@section('CSS')

@stop
@section('JS')
    {!! HTML::script("public/js/UiElements/bb_styles.js?v.5") !!}
    <script>
        $(document).ready(function () {
            $('body').on('click', '.show-entry-data', function () {
                var count = $(this).data('count');
                var id = $(this).data('id');

                $.ajax({
                    url: "/admin/console/structure/forms/get-entries-data",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {count: count, id: id},
                    success: function (data) {
                        if (!data.error) {
                            $('#entry_modal .entry-content').html(data.html);
                            $('#entry_modal').modal();
                        }
                    }
                });
            })
        })
    </script>
@stop
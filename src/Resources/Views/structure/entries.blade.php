@extends('btybug::layouts.admin')
@section('content')
    <div class="row m-b-10">
        <h3>All Entries</h3>

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>User IP</th>
                    <th>User Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="field_list">
                @if(count($entries))
                    @foreach($entries as $count => $entry)
                        <tr class="field-row">
                            <td>{!! $entry->id !!}</td>
                            <td>{!! BBgetDateFormat($entry->created_at) !!}</td>
                            <td>{!! BBgetTimeFormat($entry->created_at) !!}</td>
                            <td>{!! $entry->ip !!}</td>
                            <td>{!! ($entry->user) ? $entry->user->username or $entry->user->email : 'Guest' !!}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{!! $entry->id !!}"
                                   class="btn btn-success show-entry-data"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            No entries
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('resources::assests.magicModal')

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
@stop
@section('CSS')

@stop
@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    <script>
        $(document).ready(function () {
            $('body').on('click', '.show-entry-data', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "/admin/console/structure/forms/get-entries-data",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {id: id},
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
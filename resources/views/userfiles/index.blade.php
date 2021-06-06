@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Uploaded Files') }}
                    <a href="{{route('userfiles.create')}}" class="btn btn-primary float-right">Upload File</a></div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-message" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="content-wrapper">
                        <div class="panel panel-flat">
                            <table class="table datatable-basic dataTable no-footer" id="dataTableBuilder">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>File Name</th>
                                        <th>Created Date</th>
                                        <th>Downloads</th>
                                        <th width="80px" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('popups.share_link_popup')
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        var url = '{{route("userfiles.index")}}';
        var dTable = jQuery('#dataTableBuilder').DataTable({
            order: [],
            processing: true,
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: url,
                type: "get"
            },
            columns: [
                { data: 'id', 
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }, 
                },
                {data:'filename', name: 'filename'},
                { data: 'created_at', name: 'created_at' },
                { data: 'download', name: 'downloads' },
                {data:'action', name: 'action', class: 'text-center', searchable: false,orderable: false},
            ]
        });
    });
</script>
@endpush
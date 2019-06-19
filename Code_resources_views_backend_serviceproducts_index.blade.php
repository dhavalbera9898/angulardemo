@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.serviceproducts.management'))

@section('page-header')
<h1>{{ trans('labels.backend.serviceproducts.management') }}</h1>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.backend.serviceproducts.management') }}</h3>

        <div class="box-tools pull-right">
            @include('backend.serviceproducts.partials.serviceproducts-header-buttons')
        </div>
    </div><!--box-header with-border-->

    <div class="box-body">
        <div class="table-responsive data-table-wrapper">
            <table id="serviceproducts-table" class="table table-condensed table-hover table-bordered">
                <thead>
                    <tr>
                        <th>{{ trans('labels.backend.serviceproducts.table.title') }}</th>
                        <th>{{ trans('labels.backend.serviceproducts.table.cat_title') }}</th>
                        <th>{{ trans('labels.backend.serviceproducts.table.service_title') }}</th>
                        <th>{{ trans('labels.backend.serviceproducts.table.price') }}</th>
                        <th>{{ trans('labels.backend.serviceproducts.table.status') }}</th>
                        <th>{{ trans('labels.backend.serviceproducts.table.redeem_points') }}</th>
                        <th>{{ trans('labels.backend.serviceproducts.table.createdat') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                </thead>
                <thead class="transparent-bg">
                    <tr>
                        <th>
                           {!! Form::text('title', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.serviceproducts.table.title')]) !!}
                           <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                       </th>
                       <th>
                        {!! Form::text('category', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.serviceproducts.table.cat_title')]) !!}
                        <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                    </th>
                    <th>
                        {!! Form::text('service_title', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.serviceproducts.table.service_title')]) !!}
                        <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                    </th>
                    <th>
                       {!! Form::text('price', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.serviceproducts.table.price')]) !!}
                       <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                   </th>
                   <th>
                       {!! Form::select('status', ['0'=>'Inactive','1'=>'Active'], null, ["class" => "search-input-select form-control", "data-column" => 4, "placeholder" => trans('labels.backend.serviceproducts.table.status')]) !!}
                   </th>
                   <th>
                    {!! Form::text('redeem_points', null, ["class" => "search-input-text form-control", "data-column" => 5, "placeholder" => trans('labels.backend.serviceproducts.table.redeem_points')]) !!}
                       <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>   
                   </th>
                   <th></th>
                   <th></th>
               </tr>
           </thead>
       </table>
   </div><!--table-responsive-->
</div><!-- /.box-body -->
</div><!--box-->
@endsection

@section('after-scripts')
{{-- For DataTables --}}
{{ Html::script('public/js/dataTable.js') }}

<script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function() {
            var dataTable = $('#serviceproducts-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.serviceproducts.get") }}',
                    type: 'post',
                    data:{
                        servicecat_id:'<?php echo Session::get('servicecat_id'); ?>'
                    }
                },
                columns: [
                {data: 'title', name: '{{config('module.serviceproducts.table')}}.title'},
                {data: 'category', name: '{{config('module.servicecategories.table')}}.title'},
                {data: 'service_title', name: '{{config('module.services.table')}}.title'},
                {data: 'price', name: '{{config('module.serviceproducts.table')}}.price'},
                {data: 'status', name: '{{config('module.serviceproducts.table')}}.status'},
                {data: 'redeem_points', name: '{{config('module.serviceproducts.table')}}.redeem_points'},
                {data: 'created_at', name: '{{config('module.serviceproducts.table')}}.created_at'},
                {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[6, "DESC"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                    { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]  }},
                    { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]  }},
                    { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]  }},
                    { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]  }},
                    { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
    @endsection

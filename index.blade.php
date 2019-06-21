@extends('admin.layout.master')
@section('title','Users List')
@section('content')

<input id="ListModel" name="ListModel" type="hidden" value="{{ $ListModel}}"/>

<!-- Main content -->
<div ng-controller="userController" ng-cloak>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i><a href="{{route('admin_dashboard')}}">Home</a><i class="fa fa-angle-right"></i></li>
            <li class="active">Users List</li>
        </ul>
    </div>
    <h3 class="page-title">Users List</h3>
    @include('admin.layout.messages')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- BEGIN PORTLET-->	
            <div class="portlet light">
                <div class="portlet-body">
                    <form class="form-inline" role="form">
                        <div class="form-group form-md-line-input">

                            <div class="form-control-focus"></div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" placeholder="Search here" ng-model="ListModel.frontSearchModel.search">
                            <div class="form-control-focus"></div>
                        </div>
                        <div class="pull-right">
                            <a href="{{route('admin_user_add')}}" class="btn default blue pull-right">Add User</a>
                        </div>

                        <button type="submit" data-ng-click="SearchRecords()" class="btn default blue">Search</button>
                        <a  class="btn default red" data-ng-click="Reset()" >Reset</a>
                    </form>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>   
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-advance table-hover">

                            <thead >
                                <tr>
                                    <th class="sorting" data-ng-click="ListPager.sortColumn('name')"data-ng-class="{sorting_desc: (ListPager.sortIndex === 'name' && ListPager.reverse), sorting_asc: (ListPager.sortIndex === 'name' && !ListPager.reverse)}">Name</th>
                                    <th class="sorting" data-ng-click="ListPager.sortColumn('email')" data-ng-class="{sorting_desc: (ListPager.sortIndex === 'email' && ListPager.reverse), sorting_asc: (ListPager.sortIndex === 'email' && !ListPager.reverse)}">Email</th>
                                    <th class="sorting" data-ng-click="ListPager.sortColumn('mobile_no')" data-ng-class="{sorting_desc: (ListPager.sortIndex === 'mobile_no' && ListPager.reverse), sorting_asc: (ListPager.sortIndex === 'mobile_no' && !ListPager.reverse)}">Mobile No</th>
                                    <th class="sort-cursor" data-ng-click="ListPager.sortColumn('created_at')"data-ng-class="{sorting_desc: (ListPager.sortIndex === 'created_at' && ListPager.reverse), sorting_asc: (ListPager.sortIndex === 'created_at' && !ListPager.reverse)}">Created On</th>
                                    <th class="sorting" data-ng-click="ListPager.sortColumn('status')" data-ng-class="{sorting_desc: (ListPager.sortIndex === 'status' && ListPager.reverse), sorting_asc: (ListPager.sortIndex === 'status' && !ListPager.reverse)}">Status</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody ng-cloak>
                                
                                <tr ng-class="$even ? 'odd' : 'even'"  dir-paginate="data in UsersList | itemsPerPage:ListPager.pageSize" total-items="ListPager.totalRecords" current-page="ListPager.currentPage" pagination-id="id">				
                                    <td><a href="<?php echo URL::to('admin/user/edit'); ?>/@{{ data.EncryptedUserID}}">@{{data.name}}</a></td>
                                    <td>@{{ data.email}}</td>
                                    <td>@{{ data.mobile_no}} </td>
                                    <td>@{{ data.created_at}}</td>
                                    <td ng-cloak>
                                        <div ng-if="data.status == <?php echo App\Infrastructure\Constants::$Status_Active; ?>"><button type="button" class="btn-success btnpointer" style="border:none;">Active</button></div>
                                        <div ng-if="data.status == <?php echo App\Infrastructure\Constants::$Status_InActive; ?>"><button type="button" class="btn-danger btnpointer" style="border:none;">InActive</button></div>
                                    </td> 
                                   
                                    
                                    <td class="text-center"> 
                                        <a href="<?php echo URL::to('admin/user/edit'); ?>/@{{ data.EncryptedUserID}}" class="edit-btn inline-btn dropdown-toggle" >
                                            <i class="fa fa-pencil-square-o" title="Edit" data.hover="tooltip"></i>
                                        </a>

                                        <a href="#" class="delet-btn inline-btn dropdown-toggle" data-target="#modal-confirm" data-toggle="modal"  ng-click="setDeleteId(data.EncryptedUserID)">
                                            <i class="fa fa-trash"  title="Delete" data.hover="tooltip"></i>
                                        </a> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div ng-cloak class="alert alert-danger-no-record alert-block display-none" id="nodata"  style="display: none;">
                        <strong>{{ trans('messages.NoResult')}}</strong> <br>
                        {{ trans('messages.Refine')}}<br>
                    </div>
                    <div class="col-md-12" data-ng-if="UsersList.length > 0">
                        <dir-pagination-controls boundary-links="true"  on-page-change="ListPager.pageChanged(newPageNumber)" pagination-id="id">
                        </dir-pagination-controls>
                    </div>

                    <br/>
                    <!-- /department content --> 
                    <div id="modal-confirm" tabindex="-1"  role="dialog" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog width400px">
                            <div class="modal-content">
                                <div class="modal-body font15px">Are you sure you want to delete this record?</div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-primary" ng-click="deleteUser(delHTML)">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END PORTLET-->
        </div>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/public/pagejs/userController.js')}}"></script>
    <script>window.deleteMessage = "{{ trans('messages.deleteSuccessMessage')}}";</script>
    <script>window.deleteErrorMessage = "{{ trans('messages.deleteErrorMessage')}}";</script>
@endsection

@endsection
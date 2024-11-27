@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.orders'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.orders')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.orders')</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('orders.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_name_service')">
                                    </div>
                                    <div class="form-group col-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                        <a href="{{route('orders.index')}}" style="color: #fff" class="btn btn-dark waves-effect waves-light"><i class="fa fa-spinner"></i> </a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>@lang('dashboard.user')</th>
                                        <th>@lang('dashboard.Lawyer')</th>
                                        <th>@lang('dashboard.service')</th>
                                        <th>@lang('dashboard.firstAppointmentDate')</th>
                                        <th>@lang('dashboard.case_title')</th>
                                        <th>@lang('dashboard.status')</th>
                                        <th>@lang('dashboard.Operations')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->user?->name }}</td>
                                            <td>
                                                @permission('orders-update')
                                                @if($order->lawyer_id!=null)
                                                    {{ $order->lawyer?->name }}
                                                @else
                                                    <select
                                                        class="custom-select"
                                                        id="laywerSelect_{{ $order->id }}">
                                                        <option value=""
                                                                disabled {{ $order->lawyer_id ? '' : 'selected' }}>@lang('dashboard.select_lawyer')</option>
                                                        @foreach($lawyers as $lawyer)
                                                            <option
                                                                value="{{ $lawyer->id }}" {{$order->lawyer_id == $lawyer->id?'selected':''}}>{{ $lawyer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                @endpermission
                                            </td>
                                            <td>{{ $order->service?->t('name') }}</td>
                                            <td>{{ $order->firstAppointmentDate }}</td>
                                            <td>{{ $order->case_title }}</td>
                                            <td>
                                                @permission('orders-update')
                                                <select class="custom-select"
                                                        id="statusSelect_{{ $order->id }}">
                                                    <option
                                                        value="UNDER_REVIEW" {{ $order->status=='UNDER_REVIEW' ?  'selected' : '' }}>@lang('website.UNDER_REVIEW')</option>
                                                    <option
                                                        value="WAITING_PAYMENT" {{ $order->status=='WAITING_PAYMENT' ?  'selected' : '' }}>@lang('website.WAITING_PAYMENT')</option>
                                                    <option
                                                        value="IN_PROGRESS" {{ $order->status=='IN_PROGRESS' ?  'selected' : '' }}>@lang('website.IN_PROGRESS')</option>
                                                    @if($order->lawyer_id!=null)
                                                        <option
                                                            value="FINISHED" {{ $order->status=='FINISHED' ?  'selected' : '' }}>@lang('website.FINISHED')</option>
                                                    @endif
                                                </select>
                                                @endpermission

                                            </td>
                                            <td>
                                                <div class="operations-btns" style="">
                                                    @permission('orders-read')
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                       class="btn  btn-dark">@lang('dashboard.Show')</a>
                                                    @endpermission
                                                    @permission('orders-delete')
                                                    <button class="btn btn-danger waves-effect waves-light"
                                                            data-toggle="modal"
                                                            data-target="#delete-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>
                                                    <div id="delete-modal{{ $loop->iteration }}"
                                                         class="modal fade modal2 " tabindex="-1" role="dialog"
                                                         aria-labelledby="myModalLabel" aria-hidden="true"
                                                         style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content float-left">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">@lang('dashboard.confirm_delete')</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>@lang('dashboard.sure_delete')</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal"
                                                                            class="btn btn-dark waves-effect waves-light m-l-5 mr-1 ml-1">
                                                                        @lang('dashboard.close')
                                                                    </button>
                                                                    <form
                                                                        action="{{ route('orders.destroy', $order->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        {{ method_field('delete') }}
                                                                        <button type="submit"
                                                                                class="btn btn-danger">@lang('dashboard.Delete')</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endpermission
                                                    {{-- <a target="_blank" href="{{ route('users.loginFromAdmin', $user->id) }}" class="btn  btn-success">@lang('dashboard.Login')</a> --}}

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @include('dashboard.core.includes.no-entries', ['columns' => 8])
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{ $orders->appends(['search' => request()->search])->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('js_addons')
    <script>
        $(document).ready(function () {
            $('[id^="laywerSelect_"]').change(function () {
                var selectedLawyer = $(this).val(); // Corrected variable name
                var orderId = $(this).attr('id').split('_')[1]; // Removed $

                $.ajax({
                    url: '{{ route('order.lawyer.update', ['order' => '__order_id__']) }}'
                        .replace('__order_id__', orderId),
                    type: 'POST', // Change to POST
                    data: {
                        _method: 'PUT', // Method spoofing
                        lawyer_id: selectedLawyer,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success('@lang('messages.updated_successfully')');
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });


            $('[id^="statusSelect_"]').change(function () {
                var status = $(this).val(); // Corrected variable name
                var orderId = $(this).attr('id').split('_')[1]; // Removed $

                $.ajax({
                    url: '{{ route('order.status.update', ['order' => '__order_id__']) }}'
                        .replace('__order_id__', orderId),
                    type: 'POST', // Change to POST
                    data: {
                        _method: 'PUT', // Method spoofing
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success('@lang('messages.updated_successfully')');
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection

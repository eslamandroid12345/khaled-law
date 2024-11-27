@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.transactions'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.transactions')</h1>
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
                            <h3 class="card-title">@lang('dashboard.transactions')</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('transactions.index')}}">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="exampleInputName1">@lang('dashboard.Type')</label>
                                        <select id="type" name="type" class="form-control">
                                            <option selected disabled>@lang('dashboard.all')</option>
                                            <option @selected(request('type') == 'BANK') value="BANK">BANK</option>
                                            <option @selected(request('type') == 'ELECTRONIC') value="ELECTRONIC">ELECTRONIC</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="exampleInputName1">@lang('dashboard.Status')</label>
                                        <select id="status" name="status" class="form-control">
                                            <option selected disabled>@lang('dashboard.all')</option>
                                            <option @selected(request('status') == '1') value = 1>{{ __('dashboard.payed') }}</option>
                                            <option @selected(request('status') == '0') value = 0>{{ __('dashboard.not_payed') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3 d-flex align-items-center m-0 mt-3">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_name')">
                                    </div>
                                    <div class="form-group col-3 d-flex align-items-center m-0 mt-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                        <a  href="{{route('transactions.index')}}" style="color: #fff" class="btn mx-3 btn-dark waves-effect waves-light"><i class="fa fa-spinner"></i> </a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>@lang('dashboard.transaction_number')</th>
                                        <th>@lang('dashboard.user')</th>
                                        <th>@lang('dashboard.Type')</th>
                                        <th>@lang('dashboard.price')</th>
                                        <th>@lang('dashboard.status')</th>
                                        <th>@lang('dashboard.type_buy')</th>
                                        <th>@lang('dashboard.Operations')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> #{{ $transaction->id }}</td>
                                            <td> {{ $transaction->user->name }}</td>
                                            <td>{{ $transaction->type }}</td>
                                            <td>{{ $transaction->price }}</td>
                                            <td>{{ $transaction->status }}</td>
                                            <td>{{ $transaction->type_buy }}</td>
                                            <td>
                                                <div class="operations-btns" style="">

                                                    <a href="{{ route('transactions.show', $transaction->id) }}"
                                                       class="btn  btn-dark">@lang('dashboard.Show')</a>

{{--                                                    <button class="btn btn-danger waves-effect waves-light"--}}
{{--                                                            data-toggle="modal"--}}
{{--                                                            data-target="#delete-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>--}}
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
                                                                        action="{{ route('orders.destroy', $transaction->id) }}"
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
                            {{ $transactions->appends(['search' => request()->search , 'type' => request()->type  , 'status' => request()->status])->links() }}
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

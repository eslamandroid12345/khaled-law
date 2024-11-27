@extends('dashboard.core.app')
@section('title', __('titles.Home'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('dashboard.Home')</h1>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <a href="{{ route('users.index') }}" class="info-box-wrapper"> <!-- Example link for users -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.users')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['users']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="{{ route('lawyers.index') }}" class="info-box-wrapper"> <!-- Example link for lawyers -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.lawyers')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['lawyers']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="{{ route('categories.index') }}" class="info-box-wrapper"> <!-- Example link for categories -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.categories')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['categories']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="{{ route('services.index') }}" class="info-box-wrapper"> <!-- Example link for services -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.services')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['services']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="{{ route('orders.index') }}" class="info-box-wrapper"> <!-- Example link for orders -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.orders')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['orders']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="{{ route('legal-forms.index') }}" class="info-box-wrapper"> <!-- Example link for legal forms -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.legalforms')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['legalforms']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="{{ route('consultations.index') }}" class="info-box-wrapper"> <!-- Example link for consultations -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.consultations')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['consultations']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="#" class="info-box-wrapper"> <!-- Example link for managers -->
                                    <div class="info-box bg-dark">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">@lang('dashboard.managers')</span>
                                            <span class="info-box-number text-center mb-0">{{$data['managers']}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    @permission('orders-read')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('dashboard.orders')</h3>
                                </div>
                                <div class="card-body">
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
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    @endpermission
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@extends('dashboard.core.app')
@section('title', __('dashboard.order'))
@section('content')
    @include('dashboard.site.orders.modals.attachment-store')
    @include('dashboard.site.orders.modals.appointment-store')
    @include('dashboard.site.orders.modals.payment-store')
    @include('dashboard.site.orders.modals.update-store')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{--                    <h1>@lang('dashboard.Home')</h1>--}}
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Content Wrapper. Contains page content -->
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@lang('dashboard.order')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">@lang('dashboard.Home')</a></li>
                                <li class="breadcrumb-item active">@lang('dashboard.orders')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.order')</h3>
                                @permission('order-chat-read')
                                <div class="card-tools">
                                    <a href="{{route('order.chat',$order->id)}}"
                                       class="btn  btn-dark" >@lang('dashboard.chat')</a>
                                </div>
                                @endpermission
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <p class="lead">@lang('dashboard.the information of ') {{$order->dataTypeValue}}</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            @isset($order->user)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.user'):</th>
                                                    <td>{{$order->user?->name}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->lawyer)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.lawyer'):</th>
                                                    <td>{{$order->lawyer?->name}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->service)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.service'):</th>
                                                    <td>{{$order->service?->t('name')}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->name)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Name'):</th>
                                                    <td>{{$order->name}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->client_relationship)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.client_relationship'):</th>
                                                    <td>{{$order->client_relationship}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->national_id)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.national_id'):</th>
                                                    <td>{{$order->national_id}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->address)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.address'):</th>
                                                    <td>{{$order->address}}</td>
                                                </tr>
                                            @endisset


                                            @isset($order->email )
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Email'):</th>
                                                    <td>{{$order->email}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->phone  )
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.phone'):</th>
                                                    <td>{{$order->phone}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->case_title  )
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.case_title'):</th>
                                                    <td>{{$order->case_title}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->case_description  )
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.case_description'):</th>
                                                    <td>{{$order->case_description}}</td>
                                                </tr>
                                            @endisset
                                            @isset($order->case_conclusion  )
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.case_conclusion'):</th>
                                                    <td>{{$order->case_conclusion}}</td>
                                                </tr>
                                            @endisset
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        @permission('appointments-read')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.appointments')</h3>
                                @permission('appointments-create')
                                <div class="card-tools">
                                    <a href=""
                                       class="btn  btn-dark" data-toggle="modal"
                                       data-target="#storeAppointment">@lang('dashboard.Create')</a>
                                </div>
                                @endpermission
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>@lang('dashboard.title')</th>
                                            <th>@lang('dashboard.time')</th>
                                            <th>@lang('dashboard.meet_link')</th>
                                            <th>@lang('dashboard.Operations')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->appointments as $appointment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $appointment->title }}</td>
                                                <td>{{ $appointment->dateFormat .' '.$appointment->hourFormat }}</td>
                                                <td>@isset($appointment->meeting_link)
                                                        <a href="{{ $appointment->meeting_link }}"
                                                           target="_blank">@lang('dashboard.meet_link')</a>
                                                    @endisset</td>
                                                <td>
                                                    <div class="operations-btns" style="">
                                                        @permission('appointments-delete')
                                                        <button class="btn btn-danger waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-target="#delete-appointments-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>
                                                        <div id="delete-appointments-modal{{ $loop->iteration }}"
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
                                                                            action="{{ route('dashboard.appointments.destroy', $appointment->id) }}"
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

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            @include('dashboard.core.includes.no-entries', ['columns' => 5])
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{--                                {{ $orders->links() }}--}}
                            </div>
                        </div>
                        @endpermission
                        @permission('attachments-read')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.attachments')</h3>
                                <div class="card-tools">
                                    @permission('attachments-create')
                                    <a href=""
                                       class="btn  btn-dark" data-toggle="modal"
                                       data-target="#storeAttachment">@lang('dashboard.Create')</a>
                                    @endpermission
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>@lang('dashboard.title')</th>
                                            <th>@lang('dashboard.image')</th>
                                            <th>@lang('dashboard.Operations')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->attachments as $attachment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $attachment->title }}</td>
                                                <td>
                                                    @isset($attachment->path)
                                                        <a href="{{ $attachment->url }}" download>
                                                            <img src="{{ $attachment->iconUrl }}" width="40px"
                                                                 height="auto" alt="Appointment Icon">
                                                        </a>
                                                    @endisset
                                                </td>
                                                <td>
                                                    <div class="operations-btns" style="">
                                                        @permission('attachments-delete')
                                                        <button class="btn btn-danger waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-target="#delete-attachment-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>
                                                        <div id="delete-attachment-modal{{ $loop->iteration }}"
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
                                                                            action="{{ route('dashboard.attachments.destroy', $attachment->id) }}"
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

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            @include('dashboard.core.includes.no-entries', ['columns' => 5])
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{--                                {{ $orders->links() }}--}}
                            </div>
                        </div>
                        @endpermission
                        @permission('payments-read')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.payments')</h3>
                                <div class="card-tools">
                                    @permission('payments-create')
                                    <a href=""
                                       class="btn btn-dark" data-toggle="modal"
                                       data-target="#storePayment">@lang('dashboard.Create')</a>
                                    @endpermission
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>@lang('dashboard.title')</th>
                                            <th>@lang('dashboard.price')</th>
                                            <th>@lang('dashboard.due_date')</th>
                                            <th>@lang('dashboard.transaction_number')</th>
                                            <th>@lang('dashboard.Operations')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->t('name') }}</td>
                                                <td>{{ $payment->price }}</td>
                                                <td>{{ $payment->dueDateValueDashboard }}</td>
                                                <td>@isset($payment->transaction?->id)
                                                        #{{ $payment->transaction?->id }}
                                                    @endisset</td>
                                                <td>
                                                    <div class="operations-btns" style="">
                                                        @permission('payments-delete')
                                                        @empty($payment->transaction?->id)
                                                        <button class="btn btn-danger waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-target="#delete-payment-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>
                                                        <div id="delete-payment-modal{{ $loop->iteration }}"
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
                                                                            action="{{ route('dashboard.payments.destroy', $payment->id) }}"
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
                                                        @endempty
                                                        @endpermission

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            @include('dashboard.core.includes.no-entries', ['columns' => 5])
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{--                                {{ $orders->links() }}--}}
                            </div>
                        </div>
                        @endpermission
                        @permission('updates-read')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.updates')</h3>
                                <div class="card-tools">
                                    @permission('updates-create')
                                    <a href=""
                                       class="btn  btn-dark"  data-toggle="modal" data-target="#storeUpdate">@lang('dashboard.Create')</a>
                                    @endpermission

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>@lang('dashboard.title')</th>
                                            <th>@lang('dashboard.description')</th>
                                            <th>@lang('dashboard.date')</th>
                                            <th>@lang('dashboard.Operations')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->updates as $update)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $update->title }}</td>
                                                <td>{{ $update->description }}</td>
                                                <td>{{ $update->dayFormat .' '.$update->monthFormat }}</td>
                                                <td>
                                                    <div class="operations-btns" style="">
                                                        @permission('updates-delete')
                                                        <button class="btn btn-danger waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-target="#delete-update-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>
                                                        <div id="delete-update-modal{{ $loop->iteration }}"
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
                                                                            action="{{ route('dashboard.updates.destroy', $update->id) }}"
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

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            @include('dashboard.core.includes.no-entries', ['columns' => 5])
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @endpermission


                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{--                                {{ $orders->links() }}--}}
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_addons')

    <script>
        function previewImage() {
            var input = document.getElementById('image');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection


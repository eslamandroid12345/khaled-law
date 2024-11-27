@extends('dashboard.core.app')
@section('title', __('dashboard.transactions'))
@section('content')
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
                            <h1>@lang('dashboard.transactions')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('/')  }}">@lang('dashboard.Home')</a></li>
{{--                                <li class="breadcrumb-item active">@lang('dashboard.user')</li>--}}
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
                                <h3 class="card-title">@lang('dashboard.transactions')</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <p class="lead">#{{$transaction->id}}</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            @isset($transaction->id)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.transaction_number'):</th>
                                                <td>#{{$transaction->id}}</td>
                                            </tr>
                                            @endisset
                                            @isset($transaction->user)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.user'):</th>
                                                <td>{{$transaction->user?->name}}</td>
                                            </tr>
                                            @endisset
                                            @isset($transaction->type )
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.Type'):</th>
                                                <td>{{$transaction->type}}</td>
                                            </tr>
                                            @endisset
                                            @isset($transaction->image)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.image'):</th>
                                                    <td><img src="{{ url($transaction->image) }}" style="width: 200px;height: 250px"/></td>
                                                </tr>
                                            @endisset
                                            @isset($transaction->price)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.price'):</th>
                                                <td>{{$transaction->price}}</td>
                                            </tr>
                                            @endisset
                                            @isset($transaction->counter)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.counter'):</th>
                                                <td>{{$transaction->counter}}</td>
                                            </tr>
                                            @endisset
                                            @isset($transaction->status)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.status'):</th>
                                                <td>{{$transaction->status}}</td>
                                            </tr>
                                            @endisset
                                            @isset($transaction->type_buy)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.type_buy'):</th>
                                                    <td>{{$transaction->type_buy}}</td>
                                                </tr>
                                            @endisset
                                            @isset($transaction->address)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Address'):</th>
                                                    <td>{{$transaction->address}}</td>
                                                </tr>
                                            @endisset

                                            @isset($transaction->phone)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Phone'):</th>
                                                    <td>{{$transaction->phone}}</td>
                                                </tr>
                                            @endisset
                                            @isset($transaction->email)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Email'):</th>
                                                    <td>{{$transaction->email}}</td>
                                                </tr>
                                            @endisset

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.container-fluid -->
            </section>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Edit')</h3>
                        </div >
                        <div class="card-tools">
                            <div class="card-body">
                                <form action="{{ route('transactions.update' , $transaction->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.pay')</label>
                                            <input name="status" type="checkbox" class="form-control" id="exampleInputName1" @if($transaction->status == __('dashboard.payed')) checked @endif>
                                        </div>
                                    </div>
                                    @permission('transaction-update')
                                    @if($transaction->status == __('dashboard.not_payed'))
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.Edit')</button>
                                    @endif
                                    @endpermission
                                </form>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>

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
    <script>
        function printPdf(link)
        {
            var iframe = document.createElement('iframe');
            iframe.style.display = "none";
            // iframe.style.dir = "rtl";
            iframe.src = link;
            document.body.appendChild(iframe);
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }
    </script>
@endsection


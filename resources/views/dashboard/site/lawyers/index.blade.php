@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.lawyers'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.lawyers')</h1>
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
                            <h3 class="card-title">@lang('dashboard.lawyers')</h3>
                            <div class="card-tools">
                                @permission('lawyers-create')
                                <a href="{{ route('lawyers.create') }}"
                                   class="btn  btn-dark">@lang('dashboard.Create')</a>
                                @endpermission
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('lawyers.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_lawyer_name')">
                                    </div>
                                    <div class="form-group col-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                        <a href="{{route('lawyers.index')}}" style="color: #fff" class="btn btn-dark waves-effect waves-light"><i class="fa fa-spinner"></i> </a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.Email')</th>
                                    <th>@lang('dashboard.Phone')</th>
                                    <th>@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Active')</th>
                                    <th>@lang('dashboard.orders')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($lawyers as $lawyer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lawyer->name }}</td>
                                        <td>{{ $lawyer->email }}</td>
                                        <td>{{ $lawyer->phone }}</td>
                                        <td><img src="{{ !is_null($lawyer->image) ? url($lawyer->image) : '' }}" style="width: 100px;" /></td>
                                        <td>
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" {{$lawyer->is_active =='1'?'checked':''}} class="custom-control-input status-toggle" id="customSwitch{{ $lawyer->id }}" data-item-id="{{ $lawyer->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $lawyer->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $lawyer->lawyerOrders()?->count() }}</td>
                                      <td>
                                            <div class="operations-btns" style="">
                                                @permission('lawyers-update')
                                                <a href="{{ route('lawyers.edit', $lawyer->id) }}"
                                                   class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                                @endpermission
{{--                                                <a href="{{ route('lawyers.show', $lawyer->id) }}"--}}
{{--                                                   class="btn  btn-dark">@lang('dashboard.Show')</a>--}}
                                                @permission('lawyers-delete')
                                                    <button class="btn btn-danger waves-effect waves-light"
                                                            data-toggle="modal"
                                                            data-target="#delete-modal{{ $loop->iteration }}">@lang('dashboard.delete')</button>
                                                @endpermission
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
                                                                        action="{{ route('lawyers.destroy', $lawyer->id) }}"
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
                                    @include('dashboard.core.includes.no-entries', ['columns' => 5])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{ $lawyers->appends(['search' => request()->search])->links() }}
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
            $('.status-toggle').on('change', function () {
                var itemId = $(this).data('item-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('toggleLawyer') }}", // Replace with your actual route
                    type: "POST", // or "GET" depending on your server setup
                    data: {
                        '_token': "{{csrf_token()}}",
                        'itemId': itemId,
                        'status': status,
                        // Add any additional data you want to send with the request
                    },
                    success: function (data) {
                        if (data.success) {
                            toastr.success('@lang('messages.updated_successfully')');
                        }
                        // else {
                        //     console.log(data);
                        //     // toastr.error('Error occurred while updating.');
                        // }
                    },
                    error: function (error) {
                        console.log(error); // Log error
                        toastr.error('Error occurred while updating.');
                    }
                });
            });
        });
    </script>

@endsection

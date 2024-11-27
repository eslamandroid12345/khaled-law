@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.legalforms'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.legalforms')</h1>
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
                            <h3 class="card-title">@lang('dashboard.legalforms')</h3>
                            <div class="card-tools">
                                @permission('legalforms-create')
                                <a href="{{ route('legal-forms.create') }}"
                                   class="btn  btn-dark">@lang('dashboard.Create')</a>
                                @endpermission
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('legal-forms.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_name')">
                                    </div>
                                    <div class="form-group col-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                        <a href="{{route('legal-forms.index')}}" style="color: #fff" class="btn btn-dark waves-effect waves-light"><i class="fa fa-spinner"></i> </a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.Description')</th>
                                    <th>@lang('dashboard.price')</th>
                                    <th>@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Active')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($legalforms as $legalform)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $legalform->t('name') }}</td>
                                        <td>{{ $legalform->t('description') }}</td>
                                        <td>{{ $legalform->price }}</td>
                                        <td><img src="{{ !is_null($legalform->image) ? url($legalform->image->path) : '' }}" style="width: 100px;" /></td>
                                        <td>
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" {{$legalform->is_active == 1 ?'checked':''}} class="custom-control-input status-toggle" id="customSwitch{{ $legalform->id }}" data-item-id="{{ $legalform->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $legalform->id }}"></label>
                                            </div>
                                        </td>
                                      <td>
                                            <div class="operations-btns" style="">
                                                @permission('legalforms-update')
                                                <a href="{{ route('legal-forms.edit', $legalform->id) }}"
                                                   class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                                @endpermission
{{--                                                <a href="{{ route('lawyers.show', $lawyer->id) }}"--}}
{{--                                                   class="btn  btn-dark">@lang('dashboard.Show')</a>--}}
                                                @permission('legalforms-delete')
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
                                                                        action="{{ route('legal-forms.destroy', $legalform->id) }}"
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
                            {{ $legalforms->appends(['search' => request()->search])->links() }}
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
                    url: "{{ route('togglelegalforms') }}", // Replace with your actual route
                    type: "POST", // or "GET" depending on your server setup
                    data: {
                        '_token': "{{csrf_token()}}",
                        'itemId': itemId,
                        'status': status,
                        // Add any additional data you want to send with the request
                    },
                    success: function (data) {
                        if (data.success) {
                            toastr.success('تم التعديل بنجاح');
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

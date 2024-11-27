@extends('dashboard.core.app') <!-- upload file -->
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.services'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.services')</h1>
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
                            <h3 class="card-title">@lang('dashboard.services')</h3>
                            <div class="card-tools">
                                @permission('services-create')
                                <a href="{{ route('services.create') }}"
                                   class="btn  btn-dark">@lang('dashboard.Create')</a>
                                @endpermission
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('services.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_name')">
                                    </div>
                                    <div class="form-group col-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                        <a href="{{route('services.index')}}" style="color: #fff" class="btn btn-dark waves-effect waves-light"><i class="fa fa-spinner"></i> </a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.price')</th>
                                    <th>@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->t('name') }}</td>
                                        <td>{{ $service->price ??null }}</td>
                                        <td><img src="{{ !is_null($service->image) ? url($service->image->path) : '' }}"
                                                 style="width: 100px;"/></td>
                                        <td>
                                            <div class="operations-btns" style="">
                                                @permission('questions-read')
                                                <a href="{{ route('questions.index', $service->id) }}"
                                                   class="btn  btn-dark">@lang('dashboard.questions')</a>
                                                @endpermission
                                                @permission('services-update')
                                                <a href="{{ route('services.edit', $service->id) }}"
                                                   class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                                @endpermission
                                                {{--                                                <a href="{{ route('services.show', $service->id) }}"--}}
                                                {{--                                                   class="btn  btn-dark">@lang('dashboard.Show')</a>--}}
                                                @permission('services-delete')
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
                                                                    action="{{ route('services.destroy', $service->id) }}"
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
                            {{ $services->appends(['search' => request()->search])->links() }}
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

@endsection

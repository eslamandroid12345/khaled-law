@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.consultations'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.consultations')</h1>
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
                            <h3 class="card-title">@lang('dashboard.consultations')</h3>
                            <div class="card-tools">
{{--                                <a href="{{ route('customer-reviews.create') }}"--}}
{{--                                   class="btn  btn-dark">@lang('dashboard.Create')</a>--}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('consultations.index')}}">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="exampleInputName1">@lang('dashboard.Type')</label>
                                        <select id="type" name="type" class="form-control">
                                            <option selected disabled>@lang('dashboard.all')</option>
                                            <option @selected(request('type') == 'ONLINE') value="ONLINE">{{ __('website.online') }}</option>
                                            <option @selected(request('type') == 'OFFLINE') value="OFFLINE">{{ __('website.offline') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="exampleInputName1">@lang('dashboard.Status')</label>
                                        <select id="status" name="status" class="form-control">
                                            <option selected disabled>@lang('dashboard.all')</option>
                                            <option @selected(request('status') == 'PAIED') value="PAIED">{{ __('website.paied') }}</option>
                                            <option @selected(request('status') == 'UNPAIED') value="UNPAIED">{{ __('website.unpaied') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3 d-flex align-items-center m-0 mt-3">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_name')">
                                    </div>
                                    <div class="form-group col-3 d-flex align-items-center m-0 mt-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                        <a  href="{{route('consultations.index')}}" style="color: #fff" class="btn mx-3 btn-dark waves-effect waves-light"><i class="fa fa-spinner"></i> </a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Type')</th>
                                    <th>@lang('dashboard.Status')</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.At')</th>
                                    <th>@lang('dashboard.Lawyer')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($consultations as $consultation)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $consultation->type_value }}</td>
                                        <td>{{ $consultation->status_value }}</td>
                                        <td>{{ $consultation->name }}</td>
                                        <td>{{ $consultation->appointments?->date }}</td>
                                        <td>
                                            @permission('consultations-update')
                                            <select class="custom-select" id="laywerSelect_{{ $consultation->id }}">
                                                <option value="" disabled {{ $consultation->lawyer ? '' : 'selected' }}>@lang('dashboard.select_lawyer')</option>
                                                @foreach($lawyers as $lawyer)
                                                    <option value="{{ $lawyer->id }}" {{$consultation->lawyer?->name == $lawyer->name?'selected':''}}>{{ $lawyer->name }}</option>
                                                @endforeach
                                            </select>
                                            @endpermission
                                        </td>
{{--                                        <td>{{ $consultation->lawyer?->name }}</td>--}}
                                      <td>
                                            <div class="operations-btns" style="">
                                                @permission('consultations-update')
                                                <a href="{{ route('consultations.edit', $consultation->id) }}"
                                                   class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                                @endpermission
                                                @permission('consultations-show')
                                                <a href="{{ route('consultations.show', $consultation->id) }}"
                                                   class="btn  btn-dark">@lang('dashboard.Show')</a>
                                                @endpermission
                                                @permission('consultations-delete')
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
                                                                        action="{{ route('consultations.destroy', $consultation->id) }}"
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
                            {{ $consultations->appends(['search' => request()->search , 'type' => request()->type  , 'status' => request()->status])->links() }}
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
        $(document).ready(function() {
            $('[id^="laywerSelect_"]').change(function() {
                var selectedLawyer = $(this).val();
                var consultationId = $(this).attr('id').split('_')[1];

                $.ajax({
                    url: '{{ route('consultation.setLawyer', ['id' => '__consultation_id__']) }}'
                        .replace('__consultation_id__', consultationId),
                    type: 'GET',
                    data: {
                        lawyer_id: selectedLawyer,
                        consultation_id: consultationId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success('@lang('messages.updated_successfully')');
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

@endsection

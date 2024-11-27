@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . ' ' . __('dashboard.lawyers'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

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
                        <form action="{{ route('lawyers.update',$lawyer->id) }}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            @method('put')
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.Edit') @lang('dashboard.lawyers')</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Name')</label>
                                            <input name="name" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{$lawyer->name }}" placeholder="" required>
                                        </div>
                                    </div>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Email')</label>
                                            <input name="email" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $lawyer->email }}" placeholder="" required>
                                        </div>
                                    </div>
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.JobTitle Ar')</label>
                                            <input name="job_title_ar" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $lawyer->job_title_ar }}" placeholder="" >
                                        </div>
                                    </div>
                                    @error('job_title_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.JobTitle En')</label>
                                            <input name="job_title_en" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $lawyer->job_title_en }}" placeholder="" >
                                        </div>
                                    </div>
                                    @error('job_title_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Phone')</label>
                                            <input name="phone" type="number" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $lawyer->phone }}" placeholder="" >
                                        </div>
                                    </div>
                                    @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Image')</label>
                                            <input name="image" type="file" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $lawyer->image }}" placeholder="" >
                                        </div>
                                        @if($lawyer->image)
                                            <img src="{{ url($lawyer->image) }}" style="width: 100px;"/>
                                        @endif
                                    </div>
                                    @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                        <label for="select">@lang('dashboard.services')</label>
                                        <select id="select" name="services[]"
                                                class="select2 select2-hidden-accessible" multiple=""
                                                data-placeholder="Select Features" style="width: 100%;"
                                                data-select2-id="1" tabindex="-1" aria-hidden="true">
                                            @forelse($services as $service)
                                                <option
                                                    @if( $lawyer->services !== null && in_array($service['id'] , $lawyer->services->pluck('id')->toArray())) selected
                                                    @endif value="{{$service['id']}}">{{$service->t('name')}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    </div>
                                    @error('features')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.desc_en')</label>
                                            <textarea name="description_en" class="form-control summernote" id="exampleInputName1"  placeholder="@lang('dashboard.Review Ar')" >{!! $lawyer->description_en !!}</textarea>
                                        </div>
                                    </div>
                                    @error('description_en')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.desc_ar')</label>
                                            <textarea name="description_ar" class="form-control summernote" id="exampleInputName1"  placeholder="@lang('dashboard.Review En')" >{!! $lawyer->description_ar !!}</textarea>
                                        </div>
                                    </div>
                                    @error('description_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.password')</label>
                                            <input name="password" type="password" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ old('password') }}" placeholder="" >
                                        </div>
                                    </div>
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.password_confirmation')</label>
                                            <input name="password_confirmation" type="password" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ old('password_confirmation') }}" placeholder="" >
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-dark">@lang('dashboard.Edit')</button>
                    </div>
                    </form>
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
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            // Summernote
            $('.summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        $(function () {
            bsCustomFileInput.init();
            $('.select2').select2({
                language: {
                    searching: function () {
                    }
                },
            });
        });
    </script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2').select2({
                language: {
                    searching: function() {}
                },
            });
        });
    </script>
@endsection

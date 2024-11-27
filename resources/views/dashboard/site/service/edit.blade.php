@extends('dashboard.core.app') <!-- upload file -->
@section('title', __('dashboard.Edit') . ' ' . __('dashboard.services'))

@section('css_addons')
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
                        <form action="{{ route('services.update',$service->id) }}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            @method('put')
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.Edit') @lang('dashboard.services')</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Name Ar')</label>
                                            <input name="name_ar" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $service->name_ar }}" placeholder="@lang('dashboard.Name Ar')" >
                                        </div>
                                    </div>
                                    @error('name_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Name En')</label>
                                            <input name="name_en" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $service->name_en }}" placeholder="@lang('dashboard.Name En')" >
                                        </div>
                                    </div>
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.desc_ar')</label>
                                            <textarea name="desc_ar" class="form-control summernote" id="exampleInputName1"  placeholder="@lang('dashboard.Review Ar')" >{!! $service->desc_ar !!}</textarea>
                                        </div>
                                    </div>
                                    @error('desc_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.desc_en')</label>
                                            <textarea name="desc_en" class="form-control summernote" id="exampleInputName1"  placeholder="@lang('dashboard.Review En')" >{!! $service->desc_en !!}</textarea>
                                        </div>
                                    </div>
                                    @error('desc_en')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.required_files_ar')</label>
                                            <textarea name="required_files_ar" class="form-control summernote" id="exampleInputName1"  placeholder="@lang('dashboard.Review Ar')" >{!! $service->required_files_ar !!}</textarea>
                                        </div>
                                    </div>
                                    @error('required_files_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.required_files_en')</label>
                                            <textarea name="required_files_en" class="form-control summernote" id="exampleInputName1"  placeholder="@lang('dashboard.Review En')" >{!! $service->required_files_en !!}</textarea>
                                        </div>
                                    </div>
                                    @error('required_files_en')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.price')</label>
                                            <input name="price" type="number" class="form-control"  id="exampleInputName1" value="{{ $service->price }}" placeholder="@lang('dashboard.price')" >
                                        </div>
                                    </div>
                                    @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.categories')</label>
                                        <select name="category_id"  class="form-control" id="exampleInputName1" required >
                                            <option selected disabled>Choose type</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->t('name') }}</option>
                                                <option @if($category->id == $service->category_id) selected @endif value="{{ $category->id }}">{{ $category->t('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.image')</label>
                                            <input name="image" type="file" class="form-control"  id="exampleInputName1" value="{{ old('price') }}" placeholder="@lang('dashboard.price')" >
                                            @if($service->image)
                                                <img src="{{ $service->image->image_url }}" style="width: 100px;"/>
                                            @endif
                                        </div>
                                    </div>
                                    @error('image')
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
    <!-- <script src="{{url('/')}}/admin/plugins/summernote/summernote-bs4.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Page specific script -->
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

    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
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
@endsection

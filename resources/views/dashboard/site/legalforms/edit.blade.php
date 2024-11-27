@extends('dashboard.core.app')
@section('title', __('dashboard.Edit') . ' ' . __('dashboard.legalforms'))

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
                        <form action="{{ route('legal-forms.update',$legalform->id) }}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            @method('put')
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.Edit') @lang('dashboard.legalforms')</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Name Ar')</label>
                                            <input name="name_ar" type="text" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $legalform->name_ar }}" placeholder="" required>
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
                                                   value="{{ $legalform->name_en }}" placeholder="" required>
                                        </div>
                                    </div>
                                    @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.desc_ar')</label>
                                            <textarea name="description_ar"  class="form-control"
                                                      id="exampleInputName1">{{ $legalform->description_ar }}</textarea>
                                        </div>
                                    </div>
                                    @error('description_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.desc_en')</label>
                                            <textarea name="description_en"  class="form-control"
                                                      id="exampleInputName1">{{ $legalform->description_en }}</textarea>
                                        </div>
                                    </div>
                                    @error('description_en')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.price')</label>
                                            <input name="price" type="number" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $legalform->price }}" placeholder="" >
                                        </div>
                                    </div>
                                    @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.Image')</label>
                                            <input name="image" type="file" class="form-control"
                                                   id="exampleInputName1"
                                                   value="{{ $legalform->image }}" placeholder="" >
                                        </div>
                                        @if($legalform->image)
                                            <img src="{{ url($legalform->image->image_url) }}" style="width: 100px;"/>
                                        @endif
                                    </div>
                                    @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.file')</label>
                                            <div class="form-row align-items-center">
                                                <div class="col">
                                                    <input name="file" type="file" class="form-control" id="exampleInputName1"
                                                           value="{{ old('file') }}" placeholder="">
                                                </div>
                                                <div class="col-auto">
                                                    @if(!empty($legalform->file))
                                                    <a href="javascript:void(0)" class="btn invoice-btn m-2"
                                                       onclick="printPdf('{{ url($legalform->file) }}')"
                                                       style="background-color: #007bff; color: white; border-radius: 5px; padding: 10px 20px; text-align: center; text-decoration: none;">
                                                        @lang('dashboard.file')
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('file')
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
            bsCustomFileInput.init();
            $('.select2').select2({
                language: {
                    searching: function () {
                    }
                },
            });
        });
    </script>
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

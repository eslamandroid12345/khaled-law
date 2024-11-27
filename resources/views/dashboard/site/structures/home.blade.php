@extends('dashboard.core.app')
@section('title', __('dashboard.content') . ' ' . __('dashboard.home'))

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
                    <h1>@lang('dashboard.info_control')</h1>
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
                        <form action="{{ route('home-content.store') }}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.content') @lang('dashboard.home')</h3>
                            </div>
                            @csrf
                            <div class="card-body">
                                <!-- Hero Section -->
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.title') @lang('dashboard.home_content') @lang('dashboard.first') @lang('dashboard.ar')</label>
                                            <input name="ar[home_content][first_title]" type="text" class="form-control" id="exampleInputName1"
                                                   value="{{ $content['ar']['home_content']['first_title'] ?? ''  }}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">@lang('dashboard.title') @lang('dashboard.home_content') @lang('dashboard.first') @lang('dashboard.en')</label>
                                            <input name="en[home_content][first_title]" type="text" class="form-control"
                                                   id="exampleInputEmail1" value="{{$content['en']['home_content']['first_title'] ?? '' }}" placeholder=""
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputName1">@lang('dashboard.title') @lang('dashboard.home_content') @lang('dashboard.second') @lang('dashboard.ar')</label>
                                            <input name="ar[home_content][second_title]" type="text" class="form-control" id="exampleInputName1"
                                                   value="{{ $content['ar']['home_content']['second_title'] ?? ''  }}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">@lang('dashboard.title') @lang('dashboard.home_content') @lang('dashboard.second') @lang('dashboard.en')</label>
                                            <input name="en[home_content][second_title]" type="text" class="form-control"
                                                   id="exampleInputEmail1" value="{{$content['en']['home_content']['second_title'] ?? '' }}" placeholder=""
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-9" style="align-content: center;display: grid;">
                                                <div class="form-group" style="width: 100%;">
                                                    <label for="exampleInputFile">@lang('dashboard.image') @lang('dashboard.home_content')</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input name="ar[home_content][image]" type="hidden" value="file_125">
                                                            <input name="en[home_content][image]" type="hidden" value="file_125">
                                                            <input name="file[125]" type="file" class="custom-file-input"
                                                                   id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                            <input name="old_file[125]" type="hidden"
                                                                   value="{{ $content['ar']['home_content']['image'] ?? null }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <img src="{{ $content['ar']['home_content']['image'] ?? null }}" style="width: 60%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">@lang('dashboard.year_count') @lang('dashboard.home_content')  </label>
                                        <input name="all[home_content][year_count1]" type="number" class="form-control"
                                               id="exampleInputEmail1" value="{{$content['en']['home_content']['year_count1'] ?? '' }}" placeholder=""
                                               required>
                                    </div>
                                </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">@lang('dashboard.customer_count') @lang('dashboard.home_content')  </label>
                                            <input name="all[home_content][customer_count]" type="number" class="form-control"
                                                   id="exampleInputEmail1" value="{{$content['en']['home_content']['customer_count'] ?? '' }}" placeholder=""
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">@lang('dashboard.year_count') @lang('dashboard.home_content')  </label>
                                            <input name="all[home_content][year_count2]" type="number" class="form-control"
                                                   id="exampleInputEmail1" value="{{$content['en']['home_content']['year_count2'] ?? '' }}" placeholder=""
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-dark">@lang('dashboard.Publish')</button>
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
        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2({
                language: {
                    searching: function() {}
                },
            });
        });
    </script>
    <script>
        $('.row').on('click', '.delete_content', function (e) {
            $(this).parent().parent().remove();
        });




        let key = {{ max(array_keys($content['ar']['partners']['images'] ?? [0])) ?? 0 }} + 900;
        $('#add_partner').on('click', function () {
            key++;
            const content = '' +
                '<div class="row">' +
                '    <div class="col-6">' +
                '        <div class="form-group">' +
                '            <input name="en[partners][images][' + key + ']" type="hidden" value="file_' + key + '">' +
                '            <input name="ar[partners][images][' + key + ']" type="hidden" value="file_' + key + '">' +
                '            <input name="file[' + key + ']" type="file" class="custom-file-input" id="exampleInputFile">' +
                '            <input name="old_file[' + key + ']" type="hidden">' +
                '            <label class="custom-file-label" for="exampleInputFile">Choose file</label>' +
                '        </div>' +
                '    </div>' +
                '    <div class="col-2">' +
                '        <div class="delete_content" style="cursor: pointer;"><i style="color:red" class="nav-icon fas fa-minus-circle"></i></div>' +
                '    </div>' +
                '</div>';

            $('#partners').append(content);

        });



        key = {{ max(array_keys($content['ar']['our_services']['services'] ?? [0])) ?? 0 }} + 8000;
        $('#add_service').on('click', function () {
            key++;
            const content = '' +
                '<div class="row">' +
                '    <div class="col-3">' +
                '        <div class="form-group">' +
                '            <label for="exampleInputContent1">@lang("dashboard.title") @lang("dashboard.service") @lang("dashboard.ar")</label>' +
                '            <input name="ar[our_services][services][' + key + '][title]" type="text" class="form-control" id="exampleInputMainTitle2" placeholder="">' +
                '        </div>' +
                '    </div>' +
                '    <div class="col-3">' +
                '        <div class="form-group">' +
                '            <label for="exampleInputContent1">@lang("dashboard.title") @lang("dashboard.service") @lang("dashboard.en")</label>' +
                '            <input name="en[our_services][services][' + key + '][title]" type="text" class="form-control" id="exampleInputMainTitle2" placeholder="">' +
                '        </div>' +
                '    </div>' +
                '    <div class="col-3">' +
                '        <div class="form-group">' +
                '            <input name="en[our_services][services][' + key + '][image]" type="hidden" value="file_'+key+'">' +
                '            <input name="ar[our_services][services][' + key + '][image]" type="hidden" value="file_'+key+'">' +
                '            <input name="file['+key+']" type="file" class="custom-file-input" id="exampleInputFile">' +
                '            <input name="old_file['+key+']" type="hidden">' +
                '            <label class="custom-file-label" for="exampleInputFile">Choose file</label>' +
                '        </div>' +
                '    </div>' +
                '    <div class="col-1">' +
                '        <div class="delete_content" style="cursor: pointer;"><i style="color:red" class="nav-icon fas fa-minus-circle"></i></div>' +
                '    </div>' +
                '</div>' +
                '';

            $('#services').append(content);




        });
    </script>
@endsection

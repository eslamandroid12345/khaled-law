@extends('dashboard.core.app')
@section('title', __('dashboard.consultations'))
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
                            <h1>@lang('dashboard.consultations')</h1>
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
                                <h3 class="card-title">@lang('dashboard.consultations')</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <p class="lead">{{$consultation->name}}</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            @isset($consultation->type_value)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.Type'):</th>
                                                <td>{{$consultation->type_value}}</td>
                                            </tr>
                                            @endisset
                                            @isset($consultation->status)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.Status'):</th>
                                                <td>{{$consultation->status_value}}</td>
                                            </tr>
                                            @endisset
                                            @isset($consultation->user )
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.user'):</th>
                                                <td>{{$consultation->user?->name}}</td>
                                            </tr>
                                            @endisset

                                            <tr>
                                                <th style="width:50%">@lang('dashboard.Lawyer'):</th>
                                                <td>{{$consultation->lawyer?->name}}</td>
                                            </tr>

                                            @isset($consultation->appointments)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.At'):</th>
                                                <td>{{$consultation->appointments->date}}</td>
                                            </tr>
                                            @endisset
                                            @isset($consultation->name)
                                            <tr>
                                                <th style="width:50%">@lang('dashboard.Name'):</th>
                                                <td>{{$consultation->name}}</td>
                                            </tr>
                                            @endisset
                                            @isset($consultation->id_number)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.id_number'):</th>
                                                    <td>{{$consultation->id_number}}</td>
                                                </tr>
                                            @endisset
                                            @isset($consultation->address)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Address'):</th>
                                                    <td>{{$consultation->address}}</td>
                                                </tr>
                                            @endisset

                                            @isset($consultation->phone)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Phone'):</th>
                                                    <td>{{$consultation->phone}}</td>
                                                </tr>
                                            @endisset
                                            @isset($consultation->email)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.Email'):</th>
                                                    <td>{{$consultation->email}}</td>
                                                </tr>
                                            @endisset

                                            @isset($consultation->subject)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.subject'):</th>
                                                    <td>{{$consultation->subject}}</td>
                                                </tr>
                                            @endisset
                                            @isset($consultation->legal_question)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.legal_question'):</th>
                                                    <td>{{$consultation->legal_question}}</td>
                                                </tr>
                                            @endisset
                                            @isset($consultation->description)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.description'):</th>
                                                    <td>{{$consultation->description}}</td>
                                                </tr>
                                            @endisset

                                            @isset($consultation->attachments)
                                                <th style="width:50%">@lang('dashboard.attachments'):</th>
                                                <td>
                                                    <div class="d-flex flex-wrap">
                                                        @foreach($consultation->attachments as $attachment)
                                                            @if($attachment->type == 'FILE')
                                                                <a href="javascript:void(0)" class="btn invoice-btn m-2"
                                                                   onclick="printPdf('{{ url($attachment->path) }}')"
                                                                   style="background-color: #007bff; color: white; border-radius: 5px; padding: 10px 20px; text-align: center; text-decoration: none;">
                                                                    {{ $attachment->title }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            @endisset
                                            @isset($consultation->attachments)
                                                <tr>
                                                    <th style="width:50%">@lang('dashboard.attachments'):</th>
                                                    @foreach($consultation->attachments as $attachment)
                                                        @if($attachment->type == 'IMAGE')
                                                            <td><img src="{{ url($attachment->path) }}" style="width: 200px;height: 250px"/></td>
                                                        @endif
                                                    @endforeach
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


<!-- Modal -->
<div class="modal fade" id="storeAppointment" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">@lang('dashboard.Create') @lang('dashboard.appointments')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('appointments.store',$order->id)}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.title')</label>
                                <input name="title" required type="text" class="form-control"
                                       id="exampleInputName1"
                                       value="" placeholder="@lang('dashboard.title')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.meet_link')</label>
                                <input name="meeting_link" type="text" class="form-control"
                                       id="exampleInputName1"
                                       value="" placeholder="@lang('dashboard.meet_link')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.time')</label>
                                <input name="date" required type="datetime-local" class="form-control"
                                       id="exampleInputName1"
                                       value="" placeholder="@lang('dashboard.time')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                            data-dismiss="modal">@lang('dashboard.close')</button>
                    <button type="submit"
                            class="btn btn-dark">@lang('dashboard.Create')</button>
                </div>
            </form>
        </div>
    </div>
</div>

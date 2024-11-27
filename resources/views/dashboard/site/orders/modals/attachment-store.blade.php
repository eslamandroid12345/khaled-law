<!-- Modal -->
<div class="modal fade" id="storeAttachment" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">@lang('dashboard.Create') @lang('dashboard.attachment')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('attachments.store',$order->id)}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.attachments')</label>
                                <input name="attachments[]" multiple type="file" class="form-control"  id="exampleInputName1" value="{{ old('price') }}" placeholder="@lang('dashboard.price')" >
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

<!-- Modal -->
<div class="modal fade" id="storePayment" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">@lang('dashboard.Create') @lang('dashboard.payments')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('payments.store',$order->id)}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.Name Ar')</label>
                                <input name="name_ar" required type="text" class="form-control"
                                       id="exampleInputName1"
                                       value="{{ old('name_ar') }}" placeholder="@lang('dashboard.Name Ar')" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.Name En')</label>
                                <input name="name_en" required type="text" class="form-control"
                                       id="exampleInputName1"
                                       value="{{ old('name_en') }}" placeholder="@lang('dashboard.Name En')" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.price')</label>
                                <input name="price" required type="number" class="form-control"
                                       id="exampleInputName1"
                                       value="" placeholder="@lang('dashboard.price')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputName1">@lang('dashboard.due_date')</label>
                                <input name="due_date"  type="datetime-local" class="form-control"
                                       id="exampleInputName1"
                                       value="" placeholder="@lang('dashboard.due_date')">
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

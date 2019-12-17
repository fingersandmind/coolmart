<form action="{{ route('item.discount', $item->slug) }}" method="POST">
    @csrf
    <div class="modal fade" id="discount" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example-Modal3">Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-control-label @error('name') is-invalid @enderror">Discount Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. 20% OFF Discount.."  id="name">
                        @error('name')
                                <code class="text-danger">{{ $message }}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-slug" class="form-control-label">Discount Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option selected disabled>-------------</option>
                            <option value="percentage">Percentage</option>
                            <option value="cash_off">Cash Off</option>
                        </select>
                        @error('type')
                                <code class="text-danger">{{ $message }}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div id="input-label"></div>
                        <div id="input-type"></div>
                        @error('amount')
                                <code class="text-danger">{{ $message }}</code>
                        @enderror
                        @error('percent_off')
                                <code class="text-danger">{{ $message }}</code>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

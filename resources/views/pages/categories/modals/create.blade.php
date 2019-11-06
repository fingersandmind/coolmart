<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="createCategory" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example-Modal3">New category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name" class="form-control-label @error('name') is-invalid @enderror">Category Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"  id="name">
                            @error('name')
                                    <code class="text-danger">{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="recipient-slug" class="form-control-label">Slug</label>
                            <input type="text" name="slug" class="form-control" readonly disabled id="recipient-slug">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label @error('description') is-invalid @enderror">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="message-text">{{ old('description') }}</textarea>
                            @error('description')
                                <code class="text-danger">{{ $message }}</code>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

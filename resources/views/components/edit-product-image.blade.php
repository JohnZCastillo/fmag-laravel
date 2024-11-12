<div class="modal fade" id="editImage{{$image->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="/admin/product-image/{{$image->id}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mb-2">

                            <label class="form-label">Preview</label>

                            <div style="height: 200px">
                                <img class="img-fluid h-100 w-100"
                                     src="{{\Illuminate\Support\Facades\Storage::url($image->path)}}">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Image</label>
                            <input accept="image/*" type="file" class="form-control" name="image" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

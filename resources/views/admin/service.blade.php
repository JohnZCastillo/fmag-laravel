{% extends "./admin-index.html" %}


{% block body %}
<h4>Edit Service Details</h4>
<div class="container-fluid p-0">
    <form action="{{base_path()}}/admin/update-service/{{service.id}}" method="POST" enctype="multipart/form-data">
        <div class="modal-body p-0">
            <div class="row">
                <div class="order-2 order-md-1 col-sm-12  col-md-5">
                    <div class="form-group">
                        <label for="editImage">Image URL</label>
                        <input onchange="changePic(this)" type="file" class="form-control" id="editImage" name="image"
                               accept="image/*"
                               placeholder="Upload Image">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                               value="{{service.name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea rows="4" class="form-control" id="description" name="description"
                                  placeholder="Enter description" required>{{service.description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="acronym">Acronym</label>
                        <input type="text" class="form-control" id="acronym" name="acronym" placeholder="Enter acronym"
                               value="{{service.acronym}}" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter price"
                               value="{{service.price}}" required>
                    </div>
                </div>
                <div class="order-1 order-md-2 col-sm-12 col-md-7">
                    <div class="form-group mb-1" style="max-width: 600px">
                        <p class="mb-0">Image Preview</p>
                        <img id="previewImage" class="img-fluid" src="{{base_path()}}/uploads/{{service.image}}"
                             alt="service image">
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer justify-content-start">
            <a href="{{base_path()}}/admin/services" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>


<script>

    const changePic = (target) => {
        console.log(target);
        document.getElementById('previewImage').src = URL.createObjectURL(target.files[0]);
    }

</script>
{% endblock %}

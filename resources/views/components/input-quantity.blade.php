<div class="modal fade text-dark" id="inputModal{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form action="/order/product-checkout" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Product Quantity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input value="{{$id}}" type="hidden" name="product_id" class="d-none" id="productId{{$id}}">

                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateInputValue('#quantityInput{{$id}}',false)">-</button>
                        <input readonly name="quantity" type="number" id="quantityInput{{$id}}" class="form-control bg-white border-dark text-dark" placeholder="Quantity" min="{{$min}}" max="{{$max}}" value="1">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateInputValue('#quantityInput{{$id}}')">+</button>
                    </div>
                    <p id="remainingStockText">Remaining Stock:
                        <span id="remainingStockValue">{{$stock}}</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-edit-address">
    <div class="modal-dialog modal-edit-address">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Local Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateAddressForm" action="{{ route('local-address.store') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="address_id">
                    <input type="hidden" value="" name="sanctuary" id="edit_sanctuary">
                    <div class="form-group">
                        <label for="edit_name">Company Name*</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_address1">Address 1*</label>
                        <textarea class="form-control" id="edit_address1" name="address_1" placeholder="Address 1" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_address2">Address 2*</label>
                        <textarea class="form-control" id="edit_address2" name="address_2" placeholder="Address 2" required></textarea>
                    </div>
                        <div class="form-group">
                            <label for="edit_state">State*</label>
                            <select id="edit_state" name="state" class="form-control" required>
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->state }}"
                                        {{ old('state') == $state->state ? 'selected' : '' }}>
                                        {{ $state->state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_pincode">Pincode</label>
                            <input type="text" id="edit_pincode" class="form-control" placeholder="Pincode" name="pincode"
                                value="">

                        </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updateAddressForm">Update</button>
            </div>
        </div>
    </div>
</div>

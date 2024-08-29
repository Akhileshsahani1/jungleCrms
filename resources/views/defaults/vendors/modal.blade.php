<div class="modal fade" id="modal-vendor">
    <div class="modal-dialog modal-vendor">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Vendor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="vendorForm" action="{{ route('vendor.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label for="sanctuary">Type*</label>
                        <select class="form-control" id="sanctuary" name="sanctuary" required>
                            <option value="" selected>Select Type</option>
                            <option value="gir">Gir National Park</option>
                            <option value="jim">Jim Corbett National Park</option>
                            <option value="ranthambore">Ranthambore National Park</option>
                            <option value="tadoba">Tadoba National Park</option>
                            <option value="cab">Cab</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone*</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="alternate">Alternate Phone</label>
                        <input type="text" class="form-control" id="alternate" name="alternate" placeholder="Enter Alternate Phone Number">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="vendorForm">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-vendor">
    <div class="modal-dialog modal-edit-vendor">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Vendor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateVendorForm" action="{{ route('vendor.store') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="vendor_id">
                    <div class="form-group">
                        <label for="edit_name">Name*</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_sanctuary">Type*</label>
                        <select class="form-control" id="edit_sanctuary" name="sanctuary" required>
                            <option value="" selected>Select Type</option>
                            <option value="gir">Gir National Park</option>
                            <option value="jim">Jim Corbett National Park</option>
                            <option value="ranthambore">Ranthambore National Park</option>
                            <option value="tadoba">Tadoba National Park</option>
                            <option value="cab">Cab</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email Address</label>
                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone*</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_alternate">Alternate Phone</label>
                        <input type="text" class="form-control" id="edit_alternate" name="alternate" placeholder="Enter Alternate Phone Number">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updateVendorForm">Update</button>
            </div>
        </div>
    </div>
</div>

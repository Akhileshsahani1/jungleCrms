<div class="modal fade" id="modal-rate">
    <div class="modal-dialog modal-rate">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Permit Rate</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="rateForm" action="{{ route('permit.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="sanctuary">Sanctuary*</label>
                        <select class="form-control" id="sanctuary" name="sanctuary" required>
                            <option value="" selected>Select Sanctuary</option>
                            <option value="gir">Gir National Park</option>
                            <option value="jim">Jim Corbett National Park</option>
                            <option value="ranthambore">Ranthambore National Park</option>
                            <option value="tadoba">Tadoba National Park</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Type*</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="" selected>Select Type</option>
                            <option value="normal">Normal</option>
                            <option value="weekend">Weekend</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality*</label>
                        <select class="form-control" id="nationality" name="nationality" required>
                            <option value="" selected>Select Nationality</option>
                            <option value="indian">Indian</option>
                            <option value="foreigner">Foreigner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="rateForm">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-rate">
    <div class="modal-dialog modal-edit-rate">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Vendor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateRateForm" action="{{ route('permit.store') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="rate_id">
                    <div class="form-group">
                        <label for="edit_sanctuary">Sanctuary*</label>
                        <select class="form-control" id="edit_sanctuary" name="sanctuary" required>
                            <option value="" selected>Select Sanctuary</option>
                            <option value="gir">Gir National Park</option>
                            <option value="jim">Jim Corbett National Park</option>
                            <option value="ranthambore">Ranthambore National Park</option>
                            <option value="tadoba">Tadoba National Park</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_type">Type*</label>
                        <select class="form-control" id="edit_type" name="type" required>
                            <option value="" selected>Select Type</option>
                            <option value="normal">Normal</option>
                            <option value="weekend">Weekend</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_nationality">Nationality*</label>
                        <select class="form-control" id="edit_nationality" name="nationality" required>
                            <option value="" selected>Select Nationality</option>
                            <option value="indian">Indian</option>
                            <option value="foreigner">Foreigner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" placeholder="Enter Price">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updateRateForm">Update</button>
            </div>
        </div>
    </div>
</div>

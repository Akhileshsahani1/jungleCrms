<div class="modal fade" id="modal-hotel">
    <div class="modal-dialog modal-hotel">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Hotel Voucher (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="hotelForm" action="{{ route('voucher.hotel.terms.save') }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="filter">Type</label>
                        <select class="form-control" id="filter" name="filter" required>
                            <option value="" selected>Select Type</option>
                            <option value="normal">Normal</option>
                            <option value="weekend">Weekend</option>
                            <option value="festival">Festival</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="hotelForm">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-hotel">
    <div class="modal-dialog modal-edit-hotel">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Hotel Voucher (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updatehotelForm" action="{{ route('voucher.hotel.terms.update') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="hotel_term_id">
                    <div class="form-group">
                        <label for="edit_hotel_content">Content</label>
                        <textarea class="form-control" id="edit_hotel_content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_hotel_filter">Type</label>
                        <select class="form-control" id="edit_hotel_filter" name="filter" required>
                            <option value="" selected>Select Type</option>
                            <option value="normal">Normal</option>
                            <option value="weekend">Weekend</option>
                            <option value="festival">Festival</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updatehotelForm">Update</button>
            </div>
        </div>
    </div>
</div>

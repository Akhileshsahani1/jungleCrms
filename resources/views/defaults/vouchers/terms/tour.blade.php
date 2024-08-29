<div class="modal fade" id="modal-tour">
    <div class="modal-dialog modal-tour">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Tour Voucher (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="tourForm" action="{{ route('voucher.tour.terms.save') }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                     <div class="form-group">
                        <label for="filter">Sancturay</label>
                        <select class="form-control" id="filter" name="filter" required>
                            <option value="" selected>Select Sancturay</option>
                            <option value="gir">Gir</option>
                            <option value="jim">Jim Corbett</option>
                            <option value="ranthambore">Ranthambore</option>
                            <option value="tadoba">Tadoba</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="tourForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-tour">
    <div class="modal-dialog modal-edit-tour">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Tour Voucher (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updatetourForm" action="{{ route('voucher.tour.terms.update') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="tour_term_id">
                    <div class="form-group">
                        <label for="edit_tour_content">Content</label>
                        <textarea class="form-control" id="edit_tour_content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                     <div class="form-group">
                        <label for="edit_safari_filter">Sanctuary</label>
                        <select class="form-control" id="edit_tour_filter" name="filter" required>
                            <option value="" selected>Select Sanctuary</option>
                            <option value="gir">Gir</option>
                            <option value="jim">Jim Corbett</option>
                            <option value="ranthambore">Ranthambore</option>
                            <option value="tadoba">Tadoba</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updatetourForm">Update</button>
            </div>
        </div>
    </div>
</div>

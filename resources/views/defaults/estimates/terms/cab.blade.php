<div class="modal fade" id="modal-cab">
    <div class="modal-dialog modal-cab">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Cab Estimate (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="cabForm" action="{{ route('cab.terms.save') }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="cabForm">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-cab">
    <div class="modal-dialog modal-edit-cab">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Cab Estimate (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updatecabForm" action="{{ route('cab.terms.update') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="cab_term_id">
                    <div class="form-group">
                        <label for="edit_cab_content">Content</label>
                        <textarea class="form-control" id="edit_cab_content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updatecabForm">Update</button>
            </div>
        </div>
    </div>
</div>

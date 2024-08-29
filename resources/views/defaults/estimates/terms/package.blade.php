<div class="modal fade" id="modal-package">
    <div class="modal-dialog modal-package">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Package Estimate (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="packageForm" action="{{ route('package.terms.save') }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                   <div class="form-group">
                        <label for="filter">Destination</label>
                        <select class="form-control" id="filter" name="destination_id" required>
                            <option value="" selected>Select Type</option>
                            @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="packageForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-package">
    <div class="modal-dialog modal-edit-package">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Package Estimate (Terms & Conditions)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updatepackageForm" action="{{ route('package.terms.update') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="package_term_id">
                    <div class="form-group">
                        <label for="edit_package_content">Content</label>
                        <textarea class="form-control" id="edit_package_content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                    </div>
                     <div class="form-group">
                        <label for="filter">Destination</label>
                        <select class="form-control" id="edit_destination_id" name="destination_id" required>
                            <option value="" selected>Select Type</option>
                            @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updatepackageForm">Update</button>
            </div>
        </div>
    </div>
</div>

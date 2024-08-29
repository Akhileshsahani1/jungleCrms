<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('set-follow-up', $lead) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Follow Up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Date to be Notified*</label>

                                <div class="input-group date" id="reminder" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="datetime" data-target="#reminder" required/>
                                    <div class="input-group-append" data-target="#reminder" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @if ($errors->has('datetime'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('datetime') }}
                                    </em>
                                @endif
                            </div>

                          
                            <div class="form-group">
                                <label for="comment">Note</label>
                                <textarea class="form-control" id="comment" rows="5" name="about" placeholder="Write your note here"></textarea>
                                @if ($errors->has('about'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('about') }}
                                    </em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

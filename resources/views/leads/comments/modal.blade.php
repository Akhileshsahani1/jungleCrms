<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Lead Comments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                @if (count($lead->comments) > 0)
                    <table class="table table-bordered table-striped table-hover datatable datatable-User">
                        <thead>
                            <tr>
                                <th>
                                    Date & Time
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Comment
                                </th>

                                <th>
                                    Created By
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($lead->comments as $key => $comment)
                                <tr data-entry-id="{{ $comment->id }}">
                                    <td>
                                        {{ date('d-m-Y g:i:A', strtotime($comment->created_at)) ?? '' }}
                                    </td>
                                    <td>
                                        {{ ucfirst($comment->type) ?? '' }}
                                    </td>
                                    <td>
                                        {{ $comment->comment ?? '' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ \App\Models\User::find($comment->comment_by)->name }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center mt-4">No comments added</p>
                @endif
            </div>
        </div>
    </div>
</div>

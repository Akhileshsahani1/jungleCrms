<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Cab Halts</h3>
        </div>
        <div class="card-body">
            <table id="halt" class="table table-striped">
                <thead>
                    <tr>
                        <th>Halt</th>
                        <th>Starts from</th>
                        <th>Ends on</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($booking) && count($booking->cab->halts) > 0)
                        @foreach ($booking->cab->halts as $key => $halt)
                            <tr id="cab-halt-row{{ $key }}">
                                <td style="width:550px"><input type="text" name="halts[{{ $key }}][halt]"
                                        placeholder="Halt Destination" class="form-control"
                                        id="halt-destination{{ $key }}" value="{{ $halt->halt }}">
                                </td>
                                <td><input type="date" name="halts[{{ $key }}][start]"
                                        placeholder="Start Date" class="form-control" id="halt-start{{ $key }}"
                                        value="{{ $halt->start }}">
                                </td>
                                <td><input type="date" name="halts[{{ $key }}][end]" placeholder="End Date"
                                        class="form-control" id="halt-end{{ $key }}"
                                        value="{{ $halt->end }}">
                                </td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#cab-halt-row{{ $key }}').remove();" data-toggle="tooltip"
                                        title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach                   
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addCabHalt();"
                                data-toggle="tooltip" title="Add Halt" class="btn btn-secondary"
                                data-original-title="Add Halt"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

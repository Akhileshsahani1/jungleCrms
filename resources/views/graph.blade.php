<!-- /.card -->
<style>
  .success {
  border-color: #04AA6D;
  color: green;
}
</style>
      @if($admin)
        <div class="card bg-gradient-light">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Sales Graph
                </h3>
                <h3 class="card-title" style="margin:0 15px;">
                    <label class="col-form-label" for="saleFromDate">From Date</label>
                              <input type="text" id="saleFromDate"  placeholde="dd/mm/yyyy" name="saleFromDate" class="form-control form-control-sm">
                    </h3>
                  <h3 class="card-title" style="margin:0 15px;">
                    <label class="col-form-label" for="saleToDate">To Date</label>
                              <input type="text" id="saleToDate" placeholde="dd/mm/yyyy" name="saleToDate" class="form-control form-control-sm">
                    </h3>
                    <h3 class="card-title" style="margin:0 15px;">
                    <label class="col-form-label" for="website">Website</label>
                        <select class="form-control form-control-sm" name="website" id="website">
                          <option value="">Select website</option>
                          <option value="ranthamboretigerreserve.in">ranthamboretigerreserve.in</option>
                          <option value="jimcorbettnationalparkonline.in">jimcorbettnationalparkonline.in</option>
                          <option value="girsafaribooking.com">girsafaribooking.com</option>
                          <option value="jimcorbett.in">jimcorbett.in</option>
                          <option value="girlionsafari.com">girlionsafari.com</option>
                          <option value="girlion.in">girlion.in</option>
                          <option value="bandhavgarh.com">bandhavgarh.com</option>
                          <option value="travelwalacab.com">travelwalacab.com</option>
                          <option value="dailytourandtravel.com">dailytourandtravel.com</option>
                          <option value="rajasthan.dailytourandtravel.com">rajasthan.dailytourandtravel.com</option>
                          <option value="himachal.dailytourandtravel.com">himachal.dailytourandtravel.com</option>
                          <option value="internationaltrips.in">internationaltrips.in</option>
                          <option value="tadobapark.com">tadobapark.com</option>
                          <option value="SMO">SMO</option>
                        </select>
                    </h3>
                    <h3 class="card-title" style="margin:35px 15px 0;">
                              <input onClick="SalesGraph()" type="button" id="search" name="search" class="btn btn-primary btn-sm" value="search">
                    </h3>      
                    <h3 class="card-title" style="margin:35px 15px 0;">
                              <span id="totalSaleGraphLead" class="btn success btn-sm"></span>
                    </h3>              

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="{{ $bookings_count }}" data-max="{{$bookings_count}}" data-width="60" data-height="60"
                           data-fgColor="#eb4034">

                    <div class="text-white">Total Booking</div>
                  </div>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="{{$direct_bookings}}" data-max="{{$direct_bookings}}" data-width="60" data-height="60"
                           data-fgColor="#eaf752">

                    <div class="text-white">Direct Bookings</div>
                  </div>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="{{$converted_bookings}}" data-max="{{$converted_bookings}}" data-width="60" data-height="60"
                           data-fgColor="#5752f7">

                    <div class="text-white">Estimates converted bookings </div>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.card -->  
            <div class="card bg-gradient-light">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>Leads Graph <label class="col-form-label" for="inputState">Status</label>
                            <select id="lead_status" class="form-control form-control-sm" name="filter_status">
                                <option value="">Select Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                  </h3>
                  
                    <h3 class="card-title" style="margin:0 15px;">
                    <label class="col-form-label" for="fromDate">From Date</label>
                              <input type="text" id="fromDate"  placeholde="dd/mm/yyyy" name="fromDate" class="form-control form-control-sm">
                    </h3>
                  <h3 class="card-title" style="margin:0 15px;">
                    <label class="col-form-label" for="toDate">To Date</label>
                              <input type="text" id="toDate" placeholde="dd/mm/yyyy" name="toDate" class="form-control form-control-sm">
                    </h3>
                    <h3 class="card-title" style="margin:37px 15px 0;">
                              <input onClick="dynamicLead()" type="button" id="search" name="search" class="btn btn-primary btn-sm" value="search">
                    </h3>
                    <h3 class="card-title" style="margin:35px 15px 0;">
                              <span id="totalLead" class="btn success btn-sm"></span>
                    </h3>
                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-lead-chart" style="min-height: 250px; height: 300px; max-height: 400px; max-width: 100%;"></canvas>
              </div>
              <!-- <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="{{ $bookings_count }}" data-max="{{$bookings_count}}" data-width="60" data-height="60"
                           data-fgColor="#eb4034" id="total-lead-graph">

                    <div class="text-white">Total Leads</div>
                  </div>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="{{$bookings_count}}" data-max="{{$bookings_count}}" data-width="60" data-height="60"
                           data-fgColor="#eaf752" id="total-current-graph">

                    <div class="text-white">This Month</div>
                  </div>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="{{$bookings_count}}" data-max="{{$bookings_count}}" data-width="60" data-height="60"
                           data-fgColor="#5752f7" id="total-previous-graph">

                    <div class="text-white">Previous Month </div>
                  </div>
                </div>
              </div> -->
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
           @endif

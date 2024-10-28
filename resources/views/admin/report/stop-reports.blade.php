@extends('admin.layouts.app')
@section('panel') 
        <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3 bg-transparent">
                    <h5 class="mb-0">Stops Reports</h5>
                </div>
                <div class="card-body p-4">
                  <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-3">
                            <label for="bsValidation4" class="form-label">Device</label>
                            <select id="bsValidation4" class="form-select" required>
                                <option selected value>Select Device</option>
                                <option>One</option>
                                <option>Two</option>
                                <option>Three</option>
                            </select>
                            <div class="invalid-feedback">
                               Please select a valid Device.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="bsValidation4" class="form-label">Trip ID</label>
                            <select id="bsValidation4" class="form-select" required>
                                <option selected value>Select Trip ID</option>
                                <option>One</option>
                                <option>Two</option>
                                <option>Three</option>
                            </select>
                            <div class="invalid-feedback">
                               Please select a valid Trip ID.
                            </div>
                        </div>
                       
                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="text" class="form-control datepicker" id="bsValidation10" required>
                            <div class="invalid-feedback">
                                Please enter a valid From Date.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="text" class="form-control datepicker"  id="bsValidation10" required>
                            <div class="invalid-feedback">
                                Please enter a valid To Date.
                            </div>
                        </div>
                       
                        <div class="col-md-2 text-md-center  align-self-end ">
                          <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle  w-75" type="button" data-bs-toggle="dropdown" aria-expanded="true">Show
                            </button>
                            <ul class="dropdown-menu " data-popper-placement="top-start" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(0px, -40px);">
                              <li><a class="dropdown-item" href="#">Show</a>
                              </li>
                              <li><a class="dropdown-item" href="#">Export excel</a>
                              </li>
                            </ul>
                          </div>
                        </div>
				          </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header px-4 py-3 bg-transparent">
          <div class="row g-3">
            <div class="col-12 col-lg-4">
                <label for="Experience1" class="form-label">Device:<span class="preview">dfg34656</span></label>
            </div>
            <div class="col-12 col-lg-4">
                <label for="Position1" class="form-label">From Destination:<span class="preview">India</span> </label>
            </div>
            <div class="col-12 col-lg-4">
                <label for="Experience2" class="form-label">To Destination:<span class="preview">Bangladesh</span></label>
            </div>
            <div class="col-12 col-lg-4">
                <label for="PhoneNumber" class="form-label">Driver Name:<span class="preview">Sanket Patil</span></label>
            </div>
            <div class="col-12 col-lg-4">
                <label for="Experience3" class="form-label">Customer No:<span class="preview">123456789</span></label>
            </div>
            <div class="col-12 col-lg-4">
                <label for="PhoneNumber" class="form-label">Vehicle No:<span class="preview">MH01BG2435</span></label>
            </div>
            <div class="col-12 col-lg-4">
              <label for="Experience2" class="form-label">License No:<span class="preview">MH-2010105253418</span></label>
          </div>
          <div class="col-12 col-lg-4">
              <label for="PhoneNumber" class="form-label">ID Proof No:<span class="preview">ASFPY8904E</span></label>
          </div>
          <div class="col-12 col-lg-4">
            <label for="Experience3" class="form-label">Mobile No:<span class="preview">+918694564512</span></label>
        </div>
        <div class="col-12 col-lg-4">
            <label for="PhoneNumber" class="form-label">Co-Driver Name:<span class="preview"> Pratik Patel</span></label>
        </div>
        <div class="col-12 col-lg-4">
          <label for="Experience3" class="form-label">Co-Driver License No:<span class="preview">MH-201105789118</span></label>
        </div>
        <div class="col-12 col-lg-4">
            <label for="PhoneNumber" class="form-label">ID Proof No:<span class="preview">TSYHG8909P</span></label>
        </div>
        </div>
      </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="example2" class="table table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>Sr No.</th>
                          <th>Trip ID</th>
                          <th>Cargo Type</th>
                          <th>Stop Address</th>
                          <th>From Date</th>
                          <th>Time</th>
                          <th>To Date</th>
                          <th>Time</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>DFG345267</td>
                      <td>By Road</td>
                      <td>SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105</td> 
                      <td>2023-10-09 </td>
                      <td>10:15:50 AM</td>
                      <td>2023-10-09 </td>
                      <td>10:50:20 AM</td>

                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105</td> 
                      <td>2023-10-09 </td>
                      <td>10:15:50 AM</td>
                      <td>2023-10-09 </td>
                      <td>10:50:20 AM</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105</td> 
                      <td>2023-10-09 </td>
                      <td>10:15:50 AM</td>
                      <td>2023-10-09 </td>
                      <td>10:50:20 AM</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105</td> 
                      <td>2023-10-09 </td>
                      <td>10:15:50 AM</td>
                      <td>2023-10-09 </td>
                      <td>10:50:20 AM</td>
                    </tr>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
    @endsection
    @push('script-lib')
   
      <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush
    @push('style-lib')
      <link href="{{ asset("/assets/flatpickr/dist/flatpickr.min.css") }}" rel="stylesheet">
    <style>
      table thead tr th {
        background-color: #2E3192 !important;
        color: #fff!important;
      }
     
      </style>
    @endpush
    @push('script')
   <script>
		$(document).ready(function() {
			var table = $('#example2').DataTable({
				lengthChange: false,
                "ordering": false,
				buttons: [ 'copy', 'excel', 'pdf', 'print'],
			});
			table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)');
      $('[data-toggle="tooltip"]').tooltip();
    });
     
	 </script>
    <script>
      $(document).ready(function() {
        $('#example').DataTable();
        } );
     </script>
   <script>
        		$(".datepicker").flatpickr();

       (function () {
         'use strict'
         var forms = document.querySelectorAll('.needs-validation')
         Array.prototype.slice.call(forms)
         .forEach(function (form) {
           form.addEventListener('submit', function (event) {
           if (!form.checkValidity()) {
             event.preventDefault()
             event.stopPropagation()
           }
   
           form.classList.add('was-validated')
           }, false)
         })
       })()
   </script>
 
  </body>

</html>
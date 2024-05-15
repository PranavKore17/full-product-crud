<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body>
    <div class="bg-primary bg-gradient py-3">
        <div class="container-fluid">
            <a class="h3 text-white text-decoration-none" href="{{ route('products.index') }}">PRODUCTS HOME PAGE</a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="text-right">
            <a href="{{route('logout')}}" class="btn btn-primary mt-2">Logout</a>
        </div>

        <div class="d-flex justify-content-between py-3">

            <?php // print_r(Session::get('id'));?>

            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">Select File</label>
                <input type="file" name="file" class="form-control">

                <button type="submit" class="btn btn-primary rounded mt-2">Import File</button>
            </form>

            <form action="{{ route('export-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h6></h6>
                <label for="from">From date: </label>
                <input type="text" id="from" name="from" autocomplete="off">

                <label for="to">To date: </label>
                <input type="text" id="to" name="to"autocomplete="off">

                <button type="submit" class="btn btn-success rounded btn-sm">Export Products</button>

            </form>

            <div>
                <a href="{{ route('products.pdf') }}" class="btn btn-danger mt-2 border rounded-pill">Download PDF</a>
            </div>
            <div>
                <a class="btn btn-warning rounded-pill border  mt-2" href="{{ route('products.create') }}">Create
                    Products</a>
            </div>


        </div>

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table id="myTable" class="table table-bordered datatable" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            {{-- <th>From Date</th> --}}
                            {{-- <th>To Date</th> --}}
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Hobby</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>


<script>
    $(document).ready(function() {
        $("#myTable").slideDown("5000"); // Slide down the table when the document is ready
    });
</script>

<script>
    $(function() {

        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product_ajax') }}",
            columns: 
            [
                {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                {data: 'name',name: 'name'},                
                {data: 'email',name: 'email'},
                {data: 'address',name: 'address'},
                // {data: 'fromdate',name: 'fromdate'},
                // {data: 'todate',name: 'todate'},
                {data: 'country',name: 'country'},
                {data: 'state',name: 'state'},
                {data: 'city',name: 'city'},
                {data: 'hobby',name: 'hobby'},
                {data: 'image',name: 'image',orderable: false,searchable: false},
                {data: 'status',name: 'status',},
                {data: 'action',name: 'action'}
            ],
            lengthMenu: [ [ 5, 10, 15, -1 ], [ "five", "ten", "fiften", "All"] ],
            order:[[9,'desc']],
        });
    });
</script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


<script>
    function exportTasks(_this) {
        let _url = $(_this).data('href');
        window.location.href = _url;
    }
</script>

<script>
    function statuschange(status, id) {
        var sta = status;
        var id = id;
        // alert(sta);
        $.ajax({
            url: "{{ route('products.status') }}",
            type: "POST",
            data: 
            {id: id,
                status: sta,
                _token: "{{ csrf_token() }}"
            }, success: function(result)
            { $('.datatable').DataTable().ajax.reload();}
        })
    }
</script>


<script>
    $(function() {
        var dateFormat = "yy/mm/dd",
            from = $("#from")
            .datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
            .on("change", function() {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = $("#to").datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
            .on("change", function() {
                from.datepicker("option", "maxDate", getDate(this));
            });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }
    });
</script>
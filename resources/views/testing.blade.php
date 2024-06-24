<!DOCTYPE html>
<html>
<head>
    <title>Step-by-Step Tutorial: Implementing Yajra Datatables in Laravel 10 - CodeAndDeploy.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
     
<div class="container">
    <h1>Step-by-Step Tutorial: Implementing Yajra Datatables in Laravel 10 - CodeAndDeploy.com</h1>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomor Invoice</th>
                <th>Tenant</th>
                <th>Store Identifier</th>
                <th>Merchant Name</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Transaksi</th>
                <th>Tanggal Pembayaran</th>
                <th>Nominal Bayar</th>
                <th>MDR %</th>
                <th>Nominal MDR</th>
                <th>Nominal Terima Bersih Qris</th>
                <th>Nomor Invoice</th>
                {{-- <th width="105px">Action</th> --}}
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
     
</body>
     
<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.dashboard.mitraBisnis.transactionList.testingWoi') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            // {data: 'name', name: 'name'},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'tenant', name: 'tenant'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'merchant_name', name: 'merchant_name'},
            {data: 'status', name: 'status'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>
</html>
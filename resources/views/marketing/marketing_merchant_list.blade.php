<x-marketing-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Merchant List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Merchant List</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="" class="dropdown-item">Cetak Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Tabel Merchant List</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Invitation Code</th>
                                            <th>Nama Tenant</th>
                                            <th>Nama Toko</th>
                                            <th>Tanggal Bergabung</th>
                                            <th>Phone</th>
                                            <th>Total Insentif Mitra (Rp.)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($pemasukanMerchant->invitationCodeTenant as $inv)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $inv->invitationCode->inv_code }} - {{ $inv->invitationCode->holder }}</td>
                                                <td>{{ $inv->name }}</td>
                                                <td>{{ $inv->storeDetail->store_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($inv->created_at)->format('d-m-Y') }}</td>
                                                <td>{{ $inv->phone }}</td>
                                                <td>
                                                    {{ $inv->withdrawal_detail_sum_biaya_mitra }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('marketing.dashboard.tenant.detail', ['inv_code' => $inv->invitationCode->id, 'id' => $inv->id]) }}">
                                                        <button title="Lihat detail tenant" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-marketing-layout>
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
                                <li class="breadcrumb-item"><a href="{{ route('marketing.finance') }}">Finance</a></li>
                                <li class="breadcrumb-item active">History Penarikan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data History Penarikan</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/withdraw.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@if(is_null($penarikanTerbaru) || empty($penarikanTerbaru)) 0 @else @money($penarikanTerbaru->nominal) @endif</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Penarikan Terbaru</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/all-money.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@money($allDataSum)</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Semua Penarikan</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
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
                            <h4 class="header-title mb-3">Tabel Histori Penarikan</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Invoice</th>
                                            <th>Email</th>
                                            <th class="text-center">Tanggal Penarikan</th>
                                            <th class="text-center">Nominal (Rp.)</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach ($allData as $data)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>{{$data->invoice_pemarikan}}</td>
                                                <td>{{$data->email}}</td>
                                                <td class="text-center">
                                                    {{\Carbon\Carbon::parse($data->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($data->created_at)->format('H:i:s')}}
                                                </td>
                                                <td class="text-center">@currency($data->nominal)</td>
                                                <td class="text-center">
                                                    @if ($data->status == 0)
                                                        <span class="badge bg-soft-warning text-warning">Pending</span>
                                                    @elseif($data->status == 1)
                                                        <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                    @elseif($data->status == 2)
                                                        <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('marketing.finance.history_penarikan.invoice', ['id' => $data->id]) }}">
                                                        <button title="Lihat detail invoice" type="button" class="btn btn-primary rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>
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
        </div>
        <!-- container -->
    </div>
</x-marketing-layout>
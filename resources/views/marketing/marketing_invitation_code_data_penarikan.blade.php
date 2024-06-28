<x-marketing-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="#">UBold</a></li>
                                    <li class="breadcrumb-item"><a href="#">Apps</a></li>
                                    <li class="breadcrumb-item active">Calendar</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Invitation Code's Info</h4>
                        </div>
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
                                    <a href="" class="dropdown-item">Lihat Semua Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Revenue History</h4>
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-3"><span>Invitation Code : </span>{{ $withdrawList->inv_code }} - {{ $withdrawList->holder }}</h3>
                                </div>
                                <div class="col-6">
                                    <h3 class="mb-3 text-end"><span>Total Saldo : </span>Rp. @money($totalInsentif)</h3>
                                </div>
                            </div>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Tenant</th>
                                                    <th>Nama Toko</th>
                                                    <th class="text-center">Tanggal Penarikan</th>
                                                    <th class="text-center">Nominal (Rp.)</th>
                                                    <th class="text-center">Insentif Mitra (Rp.)</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach ($withdrawList->tenant as $tenantWD)
                                                    @foreach ($tenantWD->withdrawal as $wd)
                                                        @foreach ($wd->detailWithdraw as $dtwd)
                                                            <tr>
                                                                <td>{{ $no+=1 }}</td>
                                                                <td>{{ $tenantWD->name }}</td>
                                                                <td>{{ $tenantWD->storeDetail->store_name }}</td>
                                                                <td class="text-center">{{\Carbon\Carbon::parse($wd->tanggal_penarikan)->format('d-m-Y')}}</td>
                                                                <td class="text-center">@currency($wd->nominal)</td>
                                                                <td class="text-center">@currency($dtwd->nominal)</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
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
                                    <h3 class="mb-3"><span>Invitation Code : </span>AMAR5</h3>
                                </div>
                                <div class="col-6">
                                    <h3 class="mb-3 text-end"><span>Total Saldo : </span>Rp. 2000.000,00</h3>
                                </div>
                            </div>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Merchant ID</th>
                                                    <th>Merchant Name</th>
                                                    <th>Cash Out Date</th>
                                                    <th>Cash Out Nominal</th>
                                                    <th>Marketing Share</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>MR0001</td>
                                                    <td>Toko Bangunan Surabaya</td>
                                                    <td>01-02-2024</td>
                                                    <td>Rp. 2.000.000,00</td>
                                                    <td>Rp. 500,00</td>
                                                    <td><a href="{{ route('marketing.dashboard.invitationcode.cashout.invoice') }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;</td>
                                                </tr>
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
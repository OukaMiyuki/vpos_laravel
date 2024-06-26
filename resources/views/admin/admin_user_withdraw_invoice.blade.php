<x-marketing-layout>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu') }}">Admin Menu</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu.userWithdrawals') }}">User Withdrawals List</a></li>
                                <li class="breadcrumb-item active">Invoice</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Invoice Penarikan Dana User</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo & title -->
                            <div class="clearfix">
                                <div class="float-start">
                                    <div class="auth-logo">
                                        <div class="logo logo-dark">
                                            <span class="logo-lg">
                                                <img src="{{ asset('assets/images/logo/large.png') }}" alt="" height="40">
                                            </span>
                                        </div>

                                        <div class="logo logo-light">
                                            <span class="logo-lg">
                                                <img src="{{ asset('assets/images/logo/small.png') }}" alt="" height="22">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-end">
                                    <h4 class="m-0 d-print-none">Withdrawal Invoice</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        {{-- <p><b>Hello, Stanley Jones</b></p> --}}
                                        <p class="text-muted">
                                            Berikut terlampir bukti invoice untuk penarikan dana Qris : <strong>{{ $withdraw->invoice_pemarikan }}</strong>
                                        </p>
                                    </div>

                                </div><!-- end col -->
                                <div class="col-md-4 offset-md-2">
                                    <div class="mt-3 float-end">
                                        <table>
                                            <tr>
                                                <td><p><strong>Tanggal Penarikan</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p><span>&nbsp;&nbsp;&nbsp;&nbsp; {{\Carbon\Carbon::parse($withdraw->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($withdraw->created_at)->format('H:i:s')}}</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Status Transfer</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        @if($withdraw->status == 1)
                                                            <span class="badge bg-success">
                                                                Penarikan Sukeses
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                Penarikan Gagal
                                                            </span>
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <h6>Info Penarikan</h6>
                                    <address>
                                        <table>
                                            <tr>
                                                <td><strong>Nama</strong></td>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</strong></td>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</strong></td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Level Akun</strong></td>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</strong></td>
                                                <td><strong>{{ $userType }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Bank</strong></td>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</strong></td>
                                                <td>{{ $withdraw->rekening->nama_bank }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Atas Nama</strong></td>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</strong></td>
                                                <td>{{ $withdraw->rekening->atas_nama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>No. Rekening</strong></td>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</strong></td>
                                                <td>{{ $withdraw->rekening->no_rekening }}</td>
                                            </tr>
                                        </table>
                                    </address>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-4 table-centered">
                                            <thead>
                                                <tr>
                                                    <th width="width:5%">#</th>
                                                    <th width="width:25%">Invoice</th>
                                                    <th width="width:25%">Email</th>
                                                    <th width="width:10%">Nominal (Rp.)</th>
                                                    <th width="width:25%">Total Biaya Transfer (Rp.)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $withdraw->invoice_pemarikan }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>@money($withdraw->nominal)</td></td>
                                                    <td>@money($withdraw->biaya_admin)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="clearfix pt-5">
                                        <h6 class="text-muted">Notes:</h6>

                                        <small class="text-muted">
                                            All accounts are to be paid within 7 days from receipt of
                                            invoice. To be paid by cheque or credit card or direct payment
                                            online. If account is not paid within 7 days the credits details
                                            supplied as confirmation of work undertaken will be charged the
                                            agreed quoted fee noted above.
                                        </small>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="float-end">
                                        @if ($userType == "Mitra Tenant")
                                            @foreach ($withdraw->detailWithdraw as $dtwd)
                                                <p><b>{{$dtwd->insentif->jenis_insentif}} (Rp.) :</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; @money($dtwd->nominal)</span></p>
                                            @endforeach
                                        @elseif($userType == "Mitra Bisnis" || $userType == "Mitra Aplikasi")
                                            @php
                                                $nominalAdmin = 0;
                                            @endphp
                                            @foreach ($withdraw->detailWithdraw as $dtwd)
                                                @if($dtwd->id_insentif != 5 && $dtwd->id_insentif != 3)
                                                    <p><b>{{$dtwd->insentif->jenis_insentif}} (Rp.) :</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; @money($dtwd->nominal)</span></p>
                                                @endif
                                                @if ($dtwd->id_insentif == 5 || $dtwd->id_insentif == 3)
                                                    @php
                                                        $nominalAdmin+=$dtwd->nominal;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <p><b>Insentif Admin (Rp.) :</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; @money($nominalAdmin)</span></p>
                                        @endif
                                        <h3><b>Total (Rp.): </b> <span class="float-end">@money($withdraw->nominal+$withdraw->biaya_admin)</span></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="mt-4 mb-1">
                                <div class="text-end d-print-none">
                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div>
    </div>
</x-marketing-layout>

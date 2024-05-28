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
                                <li class="breadcrumb-item active">Saldo</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Saldo</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-xl-5">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/digital-wallet.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h2 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $qrisWallet->saldo }}</span></h2>
                                        <p class="text-muted mb-1 text-truncate">Saldo Insentif Mitra</p>
                                        <a title="Tarik Saldo" href="" class="btn btn-blue btn-sm ms-2">
                                            Tarik Saldo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-marketing-layout>
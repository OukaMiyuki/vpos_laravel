<x-tenant-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.toko') }}">Toko</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.product.stock.list') }}">Stock Product</a></li>
                                <li class="breadcrumb-item active">Barcode</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Barcode</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $bargenerator = new Picqer\Barcode\BarcodeGeneratorHTML();
                            @endphp
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">Barcode</label>
                                        <h3 id="barcode">{{ $stok->barcode }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode_image" class="form-label">Barcode Image</label>
                                        <h3 id="barcode_image">{!! $bargenerator->getBarcode($stok->barcode, $bargenerator::TYPE_CODE_128) !!}</h3>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col -->
            </div>
            <!-- end row-->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>
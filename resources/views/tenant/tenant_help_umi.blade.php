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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Qris MDR Category</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Daftar Kategori Qris</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-10 col-xl-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion custom-accordion" id="custom-accordion-one">
                                @php
                                    $no=0;
                                    $noTab=0;
                                @endphp
                                @foreach ($mdr as $mdr)
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingNine">
                                            <h5 class="m-0 position-relative">
                                                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse" href="#collapse{{$no+=1}}" aria-expanded="true" aria-controls="collapseNine">
                                                   {{$mdr->jenis_usaha}}  <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="collapse{{$noTab+=1}}" class="collapse" aria-labelledby="headingFour" data-bs-parent="#custom-accordion-one">
                                            <div class="card-body">
                                                {!! $mdr->ketentuan !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
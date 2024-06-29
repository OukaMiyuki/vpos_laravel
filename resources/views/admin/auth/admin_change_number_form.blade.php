<x-admin-layout>

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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">Change Phone Number</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Change Whatsapp Phone Number</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.phone.otp')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="no_wa_lama" class="form-label">Nomor Whatsapp Lama</label>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" readonly class="form-control" name="no_wa_lama" id="no_wa_lama" required value="{{auth()->user()->phone}}" placeholder="Masukkan nomor Whatsapp lama">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="no_wa" class="form-label">Nomor Whatsapp Baru</label>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" readonly class="form-control" name="no_wa" id="no_wa" required value="{{$nohp}}" placeholder="Masukkan nomor Whatsapp baru">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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

</x-admin-layout>
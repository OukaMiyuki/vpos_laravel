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
                            <form action="{{route('tenant.phone.otp')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="no_wa" class="form-label">Nomor Whatsapp Baru</label>
                                            <div class="row">
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="no_wa" id="no_wa" required value="" placeholder="Masukkan nomor Whatsapp baru">
                                                </div>
                                                <div class="col-4">
                                                    <button type="submit" class="w-100 btn btn-success waves-effect waves-light"><i class="mdi mdi-whatsapp"></i> Kirim Kode OTP</button>
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

</x-tenant-layout>
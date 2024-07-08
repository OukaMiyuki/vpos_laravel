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
                                <li class="breadcrumb-item active">Kontak Support</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Hubungi Mitra Aplikasi</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <form method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Mitra</label>
                                            <input required type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama mitra" readonly value="{{$kontakMarketing->marketing->name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Kode Invitasi</label>
                                            <input required type="text" name="code" id="code" class="form-control" placeholder="Masukkan kode invitasi" readonly value="{{$kontakMarketing->inv_code}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="holder" class="form-label">Holder</label>
                                            <input required type="text" name="holder" id="holder" class="form-control" placeholder="Masukkan nama holder" readonly value="{{$kontakMarketing->holder}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="nomor" class="form-label">Nomor Mitra</label>
                                            <input required type="text" name="nomor" id="nomor" class="form-control" placeholder="Masukkan nomor mitra" readonly value="{{$kontakMarketing->marketing->phone}}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="text-end">
                                <a href="https://wa.me/{{$marketingPhone}}?text=Permisi,%20saya%20adalah%20Tenant%20anda%20dan%20ingin%20melaporkan%20bug%20atau%20bertanya%20mengenai%20aplikasi%20Visioner" target="_blank"><button type="button" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-whatsapp"></i> Hubungi Mitra</button></a>
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
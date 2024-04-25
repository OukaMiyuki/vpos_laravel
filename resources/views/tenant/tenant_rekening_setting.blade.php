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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.settings') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Rekening</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pengaturan Rekening Anda</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="id_batch_product" class="form-label">Daftar Bank</label>
                                            <select required class="form-control" name="id_batch_product" id="id_batch_product" data-toggle="select2" data-width="100%">
                                                <option value="">- Pilih Daftar Bank -</option>
                                                @foreach ($dataBankList as $bank)
                                                <option value="{{$bank->swiftCode}}">{{$bank->bankName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="id_batch_product" class="form-label">Nomor Rekening</label>
                                            <input type="text" class="form-control" name="t_beli" id="t_beli" required value="" placeholder="Masukkan nomor rekening">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
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
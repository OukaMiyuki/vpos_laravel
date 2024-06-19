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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.setting') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Rekening</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Rekening Admin&nbsp;&nbsp;&nbsp;<a href="{{ route('admin.rekening.setting.add') }}"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Rekening Baru</button></a></h4></h4>
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
                                    <a href="" class="dropdown-item">Cetak Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Tabel Daftar Rekening Admin</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Rekening</th>
                                            <th>Nama Bank</th>
                                            <th>Swift Code</th>
                                            <th>Nomor Rekening</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($rekeningList as $rekening)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>{{$rekening->nama_rekening}}</td>
                                                <td>{{$rekening->nama_bank}}</td>
                                                <td>{{$rekening->swift_code}}</td>
                                                <td>{{$rekening->no_rekening}}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.rekening.setting.edit', ['id' => $rekening->id]) }}">
                                                        <button title="Edit data rekening" type="button" class="btn btn-xs btn-success waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-admin-layout>

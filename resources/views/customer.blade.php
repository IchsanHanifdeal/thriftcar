@include('layouts.head')
@include('layouts.aside')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <!-- /.col-md-6 -->
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kelola Data {{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Alamat</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Pekerjaan</th>
                                        <th>No Handphone</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if ($customer->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center label label-danger">Data customer
                                                tidak ada</td>
                                        </tr>
                                    @else
                                        @foreach ($customer as $key => $c)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $c->nama_lengkap }}</td>
                                                <td>{{ $c->alamat }}</td>
                                                <td>{{ $c->tempat . '/' . $c->tanggal_lahir }}</td>
                                                <td>{{ $c->pekerjaan }}</td>
                                                <td>{{ $c->no_handphone }}</td>
                                                <!-- Delete Button -->
                                                <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-hapus-{{ $c->id_customer }}"><i
                                                        class="fas fa-trash"></i></button></td>

                                                <!-- Modal Hapus -->
                                                <div class="modal fade" id="modal-hapus-{{ $c->id_customer }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="modal-hapusLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal-hapusLabel">
                                                                    Konfirmasi
                                                                    Hapus Data</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus {{ $title }}
                                                                <b>{{ $c->nama_lengkap }}</b>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>
                                                                <form
                                                                    action="{{ route('hapus_customer', ['id_customer' => $c->id_customer]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')

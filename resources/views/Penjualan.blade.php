@include('layouts.head')
@include('layouts.aside')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @if ($role === 'admin' || $role === 'pimpinan' || $role === 'sales')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    @endif
    @if ($role === 'customer')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian</h1>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    @endif

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card">
                        @if ($role === 'admin')
                        <div class="card-header">
                            <h3 class="card-title">Kelola Data {{ $title }}</h3>
                        </div>
                        @endif
                        @if ($role === 'customer')
                        <div class="card-header">
                            <h3 class="card-title">Kelola Data Pembelian</h3>
                        </div>
                        @endif
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Mobil</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Cara Pembayaran</th>
                                        <th>Status Pembayaran</th>
                                        <th>Total Transaksi</th>
                                        @if ($role === 'admin')
                                        <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if ($penjualan->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center label label-danger">Data
                                                {{ $title }} tidak ada</td>
                                        </tr>
                                    @else
                                        @foreach ($penjualan as $key => $p)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ ucfirst($p->customer->nama_lengkap)}}</td>
                                                <td>{{ ucfirst($p->mobil->nama_mobil) . ' type ' . $p->mobil->tipe_mobil}}</td>
                                                <td>{{ ucfirst($p->tanggal_transaksi) }}</td>
                                                <td>{{ ucfirst($p->cara_pembayaran) }}</td>
                                                <td>{{ ucfirst($p->status_pembayaran) }}</td>
                                                <td>{{ 'Rp ' . number_format($p->mobil->harga, 0, '', '.') }}</td>
                                                <!-- Delete Button -->
                                                @if ($role === 'admin')
                                                    
                                                <td><button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal-hapus-{{ $p->id_penjualan }}"><i
                                                            class="fas fa-trash"></i></button></td>

                                                <!-- Modal Hapus -->
                                                <div class="modal fade" id="modal-hapus-{{ $p->id_penjualan }}"
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
                                                                <b>{{ $p->mobil->nama_mobil }}</b>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>
                                                                <form
                                                                    action="{{ route('hapus_penjualan', ['id_penjualan' => $p->id_penjualan]) }}"
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
                                                @endif
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
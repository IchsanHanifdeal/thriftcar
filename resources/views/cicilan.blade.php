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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kelola Data {{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Customer</th>
                                        <th>Tenor</th>
                                        <th>Total Kredit</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Jumlah Pembayaran (Angsuran)</th>
                                        <th>Status Angsuran</th>
                                        <th class="no-export">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if ($cicilan->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center label label-danger">Data
                                                {{ $title }} tidak ada</td>
                                        </tr>
                                    @else
                                        @foreach ($cicilan as $key => $c)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ ucfirst($c->customer->nama_lengkap) }}</td>
                                                @php
                                                    $tenorInYears = floor($c->tenor / 12);
                                                    $remainingMonths = $c->tenor % 12;
                                                @endphp
                                                <td>
                                                    @if ($tenorInYears > 0)
                                                        {{ $tenorInYears }} Tahun
                                                        @if ($remainingMonths > 0)
                                                            {{ $remainingMonths }} Bulan
                                                        @endif
                                                    @else
                                                        {{ ucfirst($c->tenor) }} Bulan
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($c->penjualan && $c->penjualan->mobil)
                                                        {{ 'Rp ' . number_format($c->penjualan->mobil->harga, 0, '', '.') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($c->tanggal_pembayaran ?? '-') }}</td>
                                                @php
                                                    $currentDate = \Carbon\Carbon::now();
                                                    $dueDate = \Carbon\Carbon::parse($c->jatuh_tempo);
                                                    $penalty = $c->jumlah_cicilan * 0.1;
                                                    $amountDue = $currentDate->greaterThan($dueDate)
                                                        ? $c->jumlah_cicilan + $penalty
                                                        : $c->jumlah_cicilan;
                                                @endphp
                                                <td>{{ ucfirst($dueDate->locale('id')->isoFormat('D MMMM YYYY')) }}
                                                </td>
                                                <td>
                                                    {{ 'Rp ' . number_format($amountDue, 0, '', '.') }}
                                                    @if ($currentDate->greaterThan($dueDate))
                                                        (termasuk denda 10%)
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($c->status_cicilan) }}</td>
                                                @if ($role === 'customer')
                                                    <td>
                                                        @if ($c->status_cicilan === 'dibayar')
                                                            <i class="fas fa-check-circle text-success"></i>
                                                        @elseif ($key == 0 && $c->status_cicilan === 'belum lunas')
                                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#Modal-Bayar-{{ $c->id_cicilan }}">Bayar</button>
                                                        @elseif (
                                                            $key > 0 &&
                                                                isset($cicilan[$key - 1]) &&
                                                                $cicilan[$key - 1]->status_cicilan === 'dibayar' &&
                                                                $c->status_cicilan === 'belum lunas')
                                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#Modal-Bayar-{{ $c->id_cicilan }}">Bayar</button>
                                                        @else
                                                            <button class="btn btn-success btn-sm"
                                                                disabled>Bayar</button>
                                                        @endif

                                                        <div class="modal fade" id="Modal-Bayar-{{ $c->id_cicilan }}"
                                                            tabindex="-1" aria-labelledby="ModalTambah"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Cicilan tanggal
                                                                            {{ ucfirst($dueDate->locale('id')->isoFormat('D MMMM YYYY')) }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah anda akan bayar Cicilan tanggal
                                                                        <b>{{ ucfirst($dueDate->locale('id')->isoFormat('D MMMM YYYY')) }}</b>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <form
                                                                            action="{{ route('bayar_cicilan', ['id_cicilan' => $c->id_cicilan]) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button type="submit"
                                                                                class="btn btn-success">Ya</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @elseif ($role === 'admin')
                                                    <td>
                                                        @if ($c->status_cicilan === 'dibayar')
                                                            <i class="fas fa-check-circle text-success"></i>
                                                        @elseif ($c->status_cicilan === 'menunggu validasi')
                                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#Modal-terima-{{ $c->id_cicilan }}">Terima</button>
                                                            |
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#Modal-tolak-{{ $c->id_cicilan }}">Tolak</button>
                                                        @endif

                                                        <!-- Modal Terima -->
                                                        <div class="modal fade" id="Modal-terima-{{ $c->id_cicilan }}"
                                                            tabindex="-1" aria-labelledby="ModalTerimaLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="ModalTerimaLabel">
                                                                            Terima Pembayaran Cicilan</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin menerima pembayaran
                                                                        cicilan tanggal
                                                                        <b>{{ ucfirst($dueDate->locale('id')->isoFormat('D MMMM YYYY')) }}</b>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <form
                                                                            action="{{ route('terima_cicilan', ['id_cicilan' => $c->id_cicilan]) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button type="submit"
                                                                                class="btn btn-success">Ya</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Tolak -->
                                                        <div class="modal fade" id="Modal-tolak-{{ $c->id_cicilan }}"
                                                            tabindex="-1" aria-labelledby="ModalTolakLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="ModalTolakLabel">
                                                                            Tolak Pembayaran Cicilan</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin menolak pembayaran
                                                                        cicilan tanggal
                                                                        <b>{{ ucfirst($dueDate->locale('id')->isoFormat('D MMMM YYYY')) }}</b>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <form
                                                                            action="{{ route('tolak_cicilan', ['id_cicilan' => $c->id_cicilan]) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Ya</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
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

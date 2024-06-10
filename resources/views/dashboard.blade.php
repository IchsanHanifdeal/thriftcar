@include('layouts.head')
@include('layouts.aside')
@if ($role === 'customer')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }} | Pembelian Mobil</h1>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-10">
                        <div class="card">

                            <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
                                <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                                    @foreach ($mobil as $key => $m)
                                        <div class="col">
                                            <div class="card h-100 shadow-sm">
                                                <img src="{{ asset('storage/' . $m->gambar) }}" class="card-img-top"
                                                    alt="...">
                                                <div class="card-body">
                                                    <div class="clearfix mb-3"> <span
                                                            class="float-start badge rounded-pill bg-primary">{{ ucfirst($m->nama_mobil) . ' ' . 'type' . ' ' . $m->tipe_mobil }}</span><br>
                                                        <span class="float-end price-hp"><b>Harga :
                                                            </b>{{ 'Rp ' . number_format($m->harga, 0, '', '.') }}</span>
                                                    </div>
                                                    <h5 class="card-title">
                                                        <b> Merk : </b>{{ $m->merk_mobil }}<br>
                                                        <b> Transmisi : </b>{{ $m->transmisi }}<br>
                                                        <b> Warna : </b>{{ $m->warna }}<br>
                                                        <b> Stok : </b>{{ $m->stok }}<br>
                                                    </h5>
                                                    <div class="text-center my-4">
                                                        <a href="#"
                                                            class="btn btn-success mt-3 {{ $m->stok == 0 ? 'disabled' : '' }}"
                                                            id="buyButton-{{ $m->id_mobil }}">
                                                            Beli Sekarang
                                                        </a>

                                                        <script>
                                                            document.getElementById('buyButton-{{ $m->id_mobil }}').addEventListener('click', function() {
                                                                Swal.fire({
                                                                    title: 'Pilih Metode Pembayaran',
                                                                    icon: 'question',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Cash',
                                                                    cancelButtonText: 'Kredit'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.location.href = '{{ route('cash', ['id_mobil' => $m->id_mobil]) }}';
                                                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                                        window.location.href = '{{ route('kredit', ['id_mobil' => $m->id_mobil]) }}';
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif ($role === 'admin')
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
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-12 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ date('Y-m-d') }}</h3>

                                                <p>Tanggal</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ date('H:i') }}</h3>

                                                <p>Pukul</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ $total_mobil }}</h3>

                                                <p>Total Mobil</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-car"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ $total_customer }}</h3>

                                                <p>Total Customer</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ 'Rp ' . number_format($totalPenjualan, 0, ',', '.') }}</h3>

                                                <p>Total Penjualan</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ 'Rp ' . number_format($totalPenjualanHariIni, 0, ',', '.') }}</h3>

                                                <p>Total Penjualan Hari Ini</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                            <div class="inner">
                                                <h3>{{ 'Rp ' . number_format($totalPenjualanBulanIni, 0, ',', '.') }}</h3>

                                                <p>Total Penjualan Bulan Ini</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@include('layouts.footer')

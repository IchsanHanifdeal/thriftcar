@include('layouts.head')
@include('layouts.aside')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Struk Pembayaran mobil {{ $mobil->nama_mobil }} ({{ $title }})</h1>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="invoice p-3">
                <!-- Title row -->
                <div class="row">
                    <div class="col-12">
                        <div style="display: flex; align-items: center;">
                            <div style="flex: 1;">
                                <h4>{{ ucfirst($mobil->nama_mobil) . ' ' . 'type' . ' ' . $mobil->tipe_mobil }}</h4>
                                <h5>{{ 'Rp ' . number_format($mobil->harga, 0, '', '.') }}</h5>
                                <h6 class="badge rounded-pill bg-light text-dark text-wrap mb-1"
                                    style="font-size: 15px;">
                                    {{ ucfirst($mobil->warna) }}</h6>
                                <h5><i class="fas fa-map-signs"></i> {{ ucfirst($mobil->transmisi) }}</h5>
                            </div>
                            <div>
                                <span>
                                    <img src="{{ asset('imgs/logo.png') }}"
                                        style="width: 150px; height: 150px; border-radius: 50%;">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <img src="{{ asset('storage/' . $mobil->gambar) }}" class="card-img-top" />
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <div class="form-group">
                            <label for="check-in-date">Tanggal Pembelian</label>
                            <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian"
                                value="{{ date('Y-m-d') }}" readonly>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Customer data row -->
                <div class="row">
                    <div class="col-12 table-responsive mt-4">
                        <h4>Data Pembeli</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap:</th>
                                    <td>{{ $customer->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat/Tanggal Lahir</th>
                                    <td>{{ $customer->tempat . '/' . $customer->tanggal_lahir }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor HP/Telpon:</th>
                                    <td>{{ $customer->no_handphone }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan:</th>
                                    <td>{{ $customer->pekerjaan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Payment details row -->
                <div class="row">
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="{{ asset('imgs/credit/visa.png') }}" alt="Visa">
                        <img src="{{ asset('imgs/credit/mastercard.png') }}" alt="Mastercard">
                        <img src="{{ asset('imgs/credit/american-express.png') }}" alt="American Express">
                        <img src="{{ asset('imgs/credit/paypal2.png') }}" alt="Paypal">

                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango
                            imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>
                    </div>

                    <div class="col-6">
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <tr>
                                    <th>Tanggal Terkini:</th>
                                    <td>{{ date('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>Biaya Lainnya:</th>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>Biaya Mobil</th>
                                    <td>{{ 'Rp ' . number_format($mobil->harga, 0, '', '.') }}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Total Tagihan:</th>
                                    <td>{{ 'Rp ' . number_format($mobil->harga, 0, '', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Submit button -->
                <form action="{{ route('payment_cash', ['id_mobil' => $mobil->id_mobil]) }}" method="POST">
                    @csrf
                    <div class="row no-print">
                        <div class="col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="termsCheckbox" required>
                                <label class="form-check-label" for="termsCheckbox">
                                    Saya menyetujui persetujuan ketentuan yang berlaku.
                                </label>
                            </div>
                            <div class="hidden" style="display: none">
                                <input type="text" name="dp" value="{{ $mobil->harga }}">
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success" onclick="showPaymentPopup()" disabled>
                                    <i class="fas fa-credit-card"></i> Submit Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.row -->

                <!-- /.row -->

            </div>
        </div>
    </div>

</div>
@include('layouts.footer')

<script>
    const termsCheckbox = document.getElementById('termsCheckbox');
    const submitButton = document.querySelector('.btn-success');

    termsCheckbox.addEventListener('change', function() {
        if (termsCheckbox.checked) {
            submitButton.removeAttribute('disabled');
        } else {
            submitButton.setAttribute('disabled', 'disabled');
        }
    });
</script>

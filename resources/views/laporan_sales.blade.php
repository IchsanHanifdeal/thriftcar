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

    <div class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center my-4">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="month" id="filterMonth" class="form-control"
                                            placeholder="Pilih bulan" aria-label="Pilih bulan">
                                        <button class="btn btn-primary" id="applyFilter">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        @foreach (['no', 'nama sales', 'tanggal penjualan', 'nama customer', 'item terjual', 'tipe penjualan', 'harga'] as $item)
                                            <th class="text-center text-capitalize">{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody id="salesTable">
                                    @foreach ($penjualans as $index => $penjualan)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $penjualan->nama_sales }}</td>
                                            <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->format('d-m-Y') }}
                                            </td>
                                            <td>{{ $penjualan->nama_customer }}</td>
                                            <td>{{ $penjualan->item_terjual }}</td>
                                            <td>{{ ucfirst($penjualan->tipe_penjualan) }}</td>
                                            <td>Rp {{ number_format($penjualan->harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#filterMonth", {
            plugins: [new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y-m",
                altFormat: "F Y",
            })],
        });

        document.getElementById('applyFilter').addEventListener('click', function() {
            const selectedMonth = document.getElementById('filterMonth').value;
            const tableRows = document.querySelectorAll('#salesTable tr');

            tableRows.forEach(row => {
                const transactionDate = row.querySelector('td:nth-child(3)')?.textContent
            .trim();
                const rowMonth = transactionDate?.substring(3, 10);

                if (selectedMonth && rowMonth !== selectedMonth) {
                    row.style.display = "none";
                } else {
                    row.style.display = "";
                }
            });
        });
    });
</script>

@include('layouts.footer')

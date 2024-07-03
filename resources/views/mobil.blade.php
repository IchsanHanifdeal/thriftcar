@include('layouts.head')
@include('layouts.aside')
<style>
    .custom-file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .custom-file-label {
        border: 1px solid #ced4da;
        padding: .375rem .75rem;
        width: 100%;
        cursor: pointer;
        display: inline-block;
    }

    .custom-file {
        position: relative;
        width: 100%;
        height: calc(1.5em + .75rem + 2px);
    }

    .custom-file::before {
        content: 'Pilih Gambar';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: flex;
        align-items: center;
        padding: .375rem .75rem;
        pointer-events: none;
        z-index: 1;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        background-color: #fff;
    }
</style>

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
                                        <th>Gambar Mobil</th>
                                        <th>Nama Mobil</th>
                                        <th>Merk Mobil</th>
                                        <th>Warna</th>
                                        <th>Transmisi</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        @if ($role === 'admin' || $role === 'pimpinan')
                                            <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if ($mobil->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center label label-danger">Data
                                                {{ $title }} tidak ada</td>
                                        </tr>
                                    @else
                                        @foreach ($mobil as $key => $m)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalBukti-{{ $m->id_mobil }}"> Lihat
                                                        Gambar</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modalBukti-{{ $m->id_mobil }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="modalPendudukLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modalPendudukLabel">
                                                                        Gambar
                                                                        {{ $title . ' ' . ucfirst($m->nama_mobil) }}
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{ asset('storage/' . $m->gambar) }}"
                                                                        class="img-fluid" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ ucfirst($m->nama_mobil) . ' ' . 'type' . ' ' . $m->tipe_mobil }}
                                                </td>
                                                <td>{{ ucfirst($m->merk_mobil) }}</td>
                                                <td>{{ ucfirst($m->warna) }}</td>
                                                <td>{{ ucfirst($m->transmisi) }}</td>
                                                <td>{{ $m->stok }}</td>
                                                <td>{{ 'Rp ' . number_format($m->harga, 0, '', '.') }}</td>
                                                @if ($role === 'pimpinan' || $role === 'admin')
                                                    <td><button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal-edit-{{ $m->id_mobil }}"><i
                                                                class="fas fa-edit"></i></button> |

                                                        <div class="modal fade" id="modal-edit-{{ $m->id_mobil }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="modal-tambahLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modal-detailLabel">
                                                                            Edit {{ $title }}
                                                                            {{ $m->nama_mobil }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ route('update_mobil', ['id_mobil' => $m->id_mobil]) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-4 mt-2 mb-2">
                                                                                    <input type="text"
                                                                                        placeholder="Nama Mobil"
                                                                                        name="nama_mobil"
                                                                                        id="nama_mobil"
                                                                                        class="form-control"
                                                                                        value="{{ $m->nama_mobil }}">
                                                                                </div>
                                                                                <div class="col-md-4 mt-2 mb-2">
                                                                                    <input type="text"
                                                                                        placeholder="Tipe Mobil"
                                                                                        name="tipe_mobil"
                                                                                        id="tipe_mobil"
                                                                                        class="form-control"
                                                                                        value="{{ $m->tipe_mobil }}">
                                                                                </div>
                                                                                <div class="col-md-4 mt-2 mb-2">
                                                                                    <input type="text"
                                                                                        placeholder="Merk Mobil"
                                                                                        name="merk_mobil"
                                                                                        id="merk_mobil"
                                                                                        class="form-control"
                                                                                        value="{{ $m->merk_mobil }}">
                                                                                </div>
                                                                                <div class="col-md-6 mt-2 mb-2">
                                                                                    <select name="warna"
                                                                                        id="warna"
                                                                                        class="form-control">
                                                                                        <option value="">--- Pilih
                                                                                            Warna Mobil ---</option>
                                                                                        <option value="merah"
                                                                                            {{ $m->warna == 'merah' ? 'selected' : '' }}>
                                                                                            Merah</option>
                                                                                        <option value="hitam"
                                                                                            {{ $m->warna == 'hitam' ? 'selected' : '' }}>
                                                                                            Hitam</option>
                                                                                        <option value="putih"
                                                                                            {{ $m->warna == 'putih' ? 'selected' : '' }}>
                                                                                            Putih</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 mt-2 mb-2">
                                                                                    <select name="transmisi"
                                                                                        id="transmisi"
                                                                                        class="form-control">
                                                                                        <option value="">---
                                                                                            Pilih
                                                                                            Transmisi ---</option>
                                                                                        <option value="manual"
                                                                                            {{ $m->transmisi == 'manual' ? 'selected' : '' }}>
                                                                                            Manual</option>
                                                                                        <option value="matic"
                                                                                            {{ $m->transmisi == 'matic' ? 'selected' : '' }}>
                                                                                            Matic</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md-6 mt-2 mb-2">
                                                                                    <input type="number"
                                                                                        placeholder="Stok"
                                                                                        name="stok" id="stok"
                                                                                        class="form-control"
                                                                                        value="{{ $m->stok }}">
                                                                                </div>
                                                                                <div class="col-md-6 mt-2 mb-2">
                                                                                    <input type="number"
                                                                                        placeholder="Harga"
                                                                                        name="harga" id="harga"
                                                                                        class="form-control"
                                                                                        value="{{ $m->harga }}">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex justify-content-end mt-2">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary btn-sm mr-2 ml-2"
                                                                                    data-dismiss="modal">Tutup</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success btn-sm"><i
                                                                                        class="fas fa-save"></i>
                                                                                    Simpan</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Delete Button -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal-hapus-{{ $m->id_mobil }}"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>

                                                    <!-- Modal Hapus -->
                                                    <div class="modal fade" id="modal-hapus-{{ $m->id_mobil }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="modal-hapusLabel" aria-hidden="true">
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
                                                                    Apakah Anda yakin ingin menghapus
                                                                    {{ $title }}
                                                                    <b>{{ $m->nama_mobil }}</b>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                    <form
                                                                        action="{{ route('hapus_mobil', ['id_mobil' => $m->id_mobil]) }}"
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
                            @if ($role === 'admin' || $role === 'pimpinan')
                                <div class="d-flex justify-content-end">
                                    <button type="button" data-toggle="modal" data-target="#modal-tambah"
                                        class="btn btn-primary mt-2 ml-2 mr-2" href="#"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            @endif
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

<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-detailLabel">Tambah {{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('tambah_mobil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mt-2 mb-2">
                            <input type="text" placeholder="Nama Mobil" name="nama_mobil" id="nama_mobil"
                                class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-2 mb-2">
                            <input type="text" placeholder="Tipe Mobil" name="tipe_mobil" id="tipe_mobil"
                                class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-2 mb-2">
                            <input type="text" placeholder="Merk Mobil" name="merk_mobil" id="merk_mobil"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2 mb-2">
                            <select name="warna" id="warna" class="form-control" required>
                                <option value="">--- Pilih Warna Mobil ---</option>
                                <option value="merah">Merah</option>
                                <option value="hitam">Hitam</option>
                                <option value="putih">Putih</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2 mb-2">
                            <select name="transmisi" id="transmisi" class="form-control" required>
                                <option value="">--- Pilih Transmisi ---</option>
                                <option value="manual">Manual</option>
                                <option value="matic">Matic</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2 mb-2">
                            <input type="number" placeholder="Stok" name="stok" id="stok"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2 mb-2">
                            <input type="number" placeholder="Harga" name="harga" id="harga"
                                class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" name="gambar" id="gambarTambah" class="custom-file-input"
                                    onchange="previewImage(event, 'tambah')" required>
                                <label class="custom-file-label" for="gambarTambah">Pilih Gambar</label>
                            </div>
                            <div class="mt-3">
                                <img id="previewTambah" src="#" alt="Preview Gambar"
                                    class="img-fluid d-none" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-secondary btn-sm mr-2 ml-2"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i>
                            Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event, formType) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview;
                if (formType === 'tambah') {
                    preview = document.getElementById('previewTambah');
                    var label = document.querySelector('.custom-file-label[for="gambarTambah"]');
                } else {
                    preview = document.getElementById('previewEdit');
                    var label = document.querySelector('.custom-file-label[for="gambarEdit"]');
                }
                preview.src = reader.result;
                preview.classList.remove('d-none');
                label.textContent = file.name;
            }
            reader.readAsDataURL(file);
        }
    }
</script>

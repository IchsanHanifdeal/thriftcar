@include('layouts.head')
@include('layouts.aside')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }} | {{ config('app.name') }}</h1>
                </div><!-- /.col -->
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kelola Data Pengguna</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="installmentTableBody">
                                    @if ($users->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center label label-danger">Tidak Ada data
                                                Pengguna</td>
                                        </tr>
                                    @else
                                        @foreach ($users as $key => $u)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $u->email }}</td>
                                                <td>{{ ucfirst($u->role) }}</td>
                                                <td><button class="btn btn-success btn-sm" data-toggle="modal"
                                                        data-target="#modal-opsi-{{ $u->id_user }}">Opsi</button>

                                                    <div class="modal fade" id="modal-opsi-{{ $u->id_user }}"
                                                        tabindex="-1" aria-labelledby="ModalTerimaLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="ModalTerimaLabel">Ubah
                                                                        Role Pengguna</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close"> <span
                                                                            aria-hidden="true">&times;</span> </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('update_role', ['id_user' => $u->id_user]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <select name="role" id="role"
                                                                            class="form-control">
                                                                            <option value="">--- Pilih Role ---
                                                                            </option>
                                                                            <option value="admin"
                                                                                {{ $u->role == 'admin' ? 'selected' : '' }}>
                                                                                Admin</option>
                                                                            <option value="pimpinan"
                                                                                {{ $u->role == 'pimpinan' ? 'selected' : '' }}>
                                                                                Pimpinan</option>
                                                                            <option value="sales"
                                                                                {{ $u->role == 'sales' ? 'selected' : '' }}>
                                                                                Sales</option>
                                                                            <option value="customer"
                                                                                {{ $u->role == 'customer' ? 'selected' : '' }}>
                                                                                Customer</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Ya</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')

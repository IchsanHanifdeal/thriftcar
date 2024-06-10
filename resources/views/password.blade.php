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
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('ubah_password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="password"
                                    class="form-control mt-3 mb-3 @error('password_lama') is-invalid @enderror"
                                    name="password_lama" placeholder="Masukan Password Lama">
                                @error('password_lama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="password"
                                    class="form-control mt-3 mb-3 @error('password_baru') is-invalid @enderror"
                                    name="password_baru" placeholder="Masukan Password Baru">
                                @error('password_baru')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="password"
                                    class="form-control mt-3 mb-3 @error('konfirmasi_password_baru') is-invalid @enderror"
                                    name="konfirmasi_password_baru" placeholder="Ulang Masukan Password Baru">
                                @error('konfirmasi_password_baru')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary mt-3" type="submit">Ubah Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')

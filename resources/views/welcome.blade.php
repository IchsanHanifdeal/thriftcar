<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/master.css') }}">
</head>

<body>
    <div class="setting-box" style="display: none">
        <div class="toggle-setting">
            <i class="fa fa-gear"></i>
        </div>
        <div class="setting-container">
            <div class="option-box">
                <h4>Colors</h4>
                <ul class="colors-list">
                    <li class="active" data-color="#4CAF50"></li>
                    <li data-color="#FF9800"></li>
                    <li data-color="#E91E63"></li>
                    <li data-color="#009688"></li>
                    <li data-color="#03A9F4"></li>
                </ul>
            </div>
            <div class="option-box">
                <h4>Background Random</h4>
                <div class="background-option">
                    <span class="yes active" data-option="yes">Yes</span>
                    <span class="no" data-option="no">No</span>
                </div>
            </div>
            <div class="option-box">
                <h4>Show Bullet</h4>
                <div class="bullets-option">
                    <span class="yes active" data-display="yes">Show</span>
                    <span class="no" data-display="no">Hide</span>
                </div>
            </div>
            <button class="rest-option">Rest Option</button>
        </div>
    </div>
    <div class="landing-page">
        <div class="overlay"></div>
        <div class="header-area">
            <div class="logo">{{ config('app.name') }}</div>
            <div class="links-container">
                <ul class="links">
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#mobil">Mobil</a></li>
                    <li><a href="#galeri">Galeri</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
                <button type="reset" class="toggle-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
        <div class="introduction-text">
            <h1>Selamat Datang di <span>{{ config('app.name') }}</span> </h1>
            <p>Kami bangga menawarkan Anda pengalaman terbaik untuk memilih mobil yang sempurna. Apakah Anda sedang
                mencari yang baru atau bekas kendaraan, kami siap membantu Anda mengambil keputusan yang tepat.</p>
        </div>
    </div>
    <div class="container">
        <div class="about-us">
            <div class="info-box" id="tentang">
                <h2>Tentang Kami</h2>
                <p>Dalam pameran kami, Anda akan menemukan beragam mobil dari berbagai merek dan kategori. Kami selalu
                    berusaha untuk menyediakan
                    penawaran dan layanan terbaik kepada pelanggan kami yang berharga.

                    Nikmati menjelajahi pameran kami, dan jangan ragu untuk menanyakan tentang mobil apa pun yang
                    menarik minat Anda.
                    Kami di sini untuk melayani
                    Anda dan jadikan pengalaman Anda luar biasa.

                    Terima kasih telah berkunjung, dan kami nantikan kedatangan Anda di pameran kami</p>
            </div>
            <div class="img-box">
                @if($mobils->isNotEmpty())
                    @php
                        $firstMobil = $mobils->first();
                    @endphp
                    <img src="{{ asset('storage/' . $firstMobil->gambar) }}" alt="{{ $firstMobil->nama_mobil }}">
                @endif
            </div>            
        </div>
    </div>
    <div class="skills" id="mobil">
        <div class="container">
            <h2>Mobil Kami</h2>
            @foreach ($mobils as $mobil)
                <div class="skill-box">
                    <div class="skill-name">{{ $mobil->nama_mobil }}</div>
                    @php
                        $totalPenjualan = $mobil->penjualans->count();
                        $progressPercentage =
                            $totalPenjualanAll != 0 ? ($totalPenjualan / $totalPenjualanAll) * 100 : 0;
                    @endphp
                    <div class="skill-progress">
                        <span style="width: {{ $progressPercentage }}%;"
                            data-progress="{{ $progressPercentage }}%"></span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="gallery" id="galeri">
        <div class="container">
            <h2>Mobil bekas bergaransi</h2>
            <div class="img-box">
                @foreach ($mobils as $mobil)
                    <img src="{{ asset('storage/' . $mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}">
                @endforeach
            </div>
        </div>
    </div>
    <div class="features" id="fitur">
        <h2>Fitur Kami</h2>
        <div class="container">
            <div class="feat-box">
                <img src="imgs/features-1.jpg" alt="features-1-image">
                <h3>Pesan mobil dengan mengklik tombol</h3>
                <p>Pesan mobil melalui pembayaran yang dipotong dari harga mobil</p>
            </div>
            <div class="feat-box">
                <img src="imgs/features-2.jpg" alt="features-2-image">
                <h3>Metode pembayaran elektronik yang aman</h3>
                <p>Metode pembayaran elektronik yang aman untuk membayar mobil</p>
            </div>
            <div class="feat-box">
                <img src="imgs/features-3.jpg" alt="features-3-image">
                <h3>Kami melakukan semua prosedur</h3>
                <p>Seorang karyawan yang berdedikasi untuk melayani Anda akan menghubungi Anda untuk menyelesaikan
                    pengalihan kepemilikan,
                    asuransi dan garansi</p>
            </div>
            <div class="feat-box">
                <img src="imgs/features-4.jpg" alt="features-4-image">
                <h3>Kami mengantarkan mobil ke rumah Anda</h3>
                <p>Periksa mobil selama 10 hari, dan jika tidak sesuai, Anda dapat mengembalikannya dan mendapatkan
                    harganya kembali</p>
            </div>
            <div class="feat-box">
                <img src="imgs/features-5.jpg" alt="features-5-image">
                <h3>Memperbarui dan menyiapkan mobil</h3>
                <p>Agar Anda menerimanya dalam kondisi prima, kami melakukan perawatan menyeluruh terhadapnya
                    mobil dan menyiapkannya
                    sepenuhnya oleh teknisi profesional di pusat-pusat khusus yang dilengkapi dengan teknologi terkini
                    teknologi.</p>
            </div>
            <div class="feat-box">
                <img src="imgs/features-6.jpg" alt="features-6-image">
                <h3>Opsi pembiayaan</h3>
                <p>Kami memberi Anda berbagai opsi pembiayaan melalui berbagai pihak pembiayaan.</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <script src="{{ asset('javaScript/script.js') }}"></script>
</body>

</html>

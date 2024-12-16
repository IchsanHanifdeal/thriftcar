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
                mencari kendaraan yang baru?, kami siap membantu Anda mengambil keputusan yang tepat.</p>
        </div>
    </div>
    <div class="container">
        <div class="about-us">
            <div class="info-box" id="tentang">
                <h2>Tentang Kami</h2>
                <p>Dalam showroom kami, Anda akan menemukan beragam mobil dari berbagai merek dan kategori. Kami selalu
                    berusaha untuk menyediakan
                    penawaran dan layanan terbaik kepada pelanggan kami yang berharga.

                    Nikmati menjelajahi showroom kami, dan jangan ragu untuk menanyakan tentang mobil apa pun yang
                    menarik minat Anda.
                    Kami di sini untuk melayani
                    Anda dan jadikan pengalaman Anda luar biasa.

                    Terima kasih telah berkunjung, dan kami nantikan kedatangan Anda di showroom kami</p>
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
            <h2>Mobil Baru bergaransi</h2>
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
                <img src="data:image/jpeg;base64,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" alt="features-1-image">
                <h3>Pesan mobil dengan mengklik tombol</h3>
                <p>Pesan mobil melalui pembayaran yang dipotong dari harga mobil</p>
            </div>
            <div class="feat-box">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHwmseRTdKVRsSd0Ey90jDlWQDIokmv6YeFg&s" alt="features-2-image">
                <h3>Metode pembayaran elektronik yang aman</h3>
                <p>Metode pembayaran elektronik yang aman untuk membayar mobil</p>
            </div>
            <div class="feat-box">
                <img src="https://imgcdn.oto.com/large/gallery/interior/38/1654/toyota-avanza-front-seats-640980.jpg" alt="features-3-image">
                <h3>Kami melakukan semua prosedur</h3>
                <p>Seorang karyawan yang berdedikasi untuk melayani Anda akan menghubungi Anda untuk menyelesaikan
                    pengalihan kepemilikan,
                    asuransi dan garansi</p>
            </div>
            <div class="feat-box">
                <img src="https://www.blibli.com/friends-backend/wp-content/uploads/2022/05/Yuk-Intip-Interior-Avanza-Veloz-2022.png" alt="features-4-image">
                <h3>Kami mengantarkan mobil ke rumah Anda</h3>
                <p>Periksa mobil selama 10 hari, dan jika tidak sesuai, Anda dapat mengembalikannya dan mendapatkan
                    harganya kembali</p>
            </div>
            <div class="feat-box">
                <img src="https://www.olx.co.id/news/wp-content/uploads/2024/03/toyota-raize-1-696x464.webp" alt="features-5-image">
                <h3>Memperbarui dan menyiapkan mobil</h3>
                <p>Agar Anda menerimanya dalam kondisi prima, kami melakukan perawatan menyeluruh terhadapnya
                    mobil dan menyiapkannya
                    sepenuhnya oleh teknisi profesional di pusat-pusat khusus yang dilengkapi dengan teknologi terkini
                    teknologi.</p>
            </div>
            <div class="feat-box">
                <img src="https://imgcdn.oto.com/large/gallery/interior/38/2367/toyota-raize-dashboard-view-542516.jpg" alt="features-6-image">
                <h3>Opsi pembiayaan</h3>
                <p>Kami memberi Anda berbagai opsi pembiayaan melalui berbagai pihak pembiayaan.</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <script src="{{ asset('javaScript/script.js') }}"></script>
</body>

</html>

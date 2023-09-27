<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Kartu Anggota Koperasi</title>
        <style>
            * {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #ffffff;
            }

            .card {
                max-width: 100vw;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                border-radius: 10px;
                max-height: 100vh;

            }

            .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logo img {
                max-width: 100px;
            }

            .koperasi-info {
                text-align: center;
            }

            .koperasi-info h1 {
                margin: 0;
            }

            .koperasi-info p {
                margin: 5px 0;
            }

            hr {
                border: 1px solid #ccc;
                margin: 20px 0;
            }

            .anggota-info h2,
            .sekolah-info h2 {
                margin-top: 20px;
            }

            .anggota-info p,
            .sekolah-info p {
                margin: 5px 0;
            }
            .img-fluid {
                max-width: 100%;
                height: auto;
            }
            /* bulat */
            .circle {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: #fff;
                border: 1px solid #ccc;
                margin: 0 auto;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="header">
                <div class="logo" style="text-align: center">
                    <img src="https://kgc.poineko.my.id/assets/images/logo.jpeg"
                    alt="Logo"  class="img-fluid"/>
                </div>
                <div class="koperasi-info">
                    <h4>KANCAWINAYA GURU CISITU</h4>
                    <p style="font-size: 12px">
                        <b
                            >NOMOR AHU-0001852/AJ/-1/38/TAHUN 2022
                            TANGGAL 28 SEPTEMBER 2022</b
                        >
                    </p>
                    <p style="font-size: 12px; font-style: italic">
                        Alamat Jalan Raya Umar Wirahadikusumah / Jalan Darmaraja KM 18 Kecamatan Cisitu Kabutan Sumedang.
                    </p>
                </div>
            </div>
            <hr />
            <div class="anggota-info">
                <h3>Biodata Anggota</h3>
                <p><strong>ID Anggota:</strong> {{$anggota->id_anggota}}</p>
                <p><strong>Nama:</strong> {{$anggota->nama}}</p>
                <p><strong>Tanggal Lahir:</strong> {{$anggota->tanggal_lahir}}</p>
                <p>
                    <strong>Alamat:</strong> {{$anggota->alamat}}
                </p>
                <p>
                    <strong>Sekolah / Pekerjaan:</strong> {{$anggota->sekolah->nama ?? '-'}}
                </p>
            </div>
        </div>
    </body>
</html>

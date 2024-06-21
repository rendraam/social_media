<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .upload-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .upload-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }
        .upload-container p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #666;
        }
        .upload-container input[type="file"] {
            margin-bottom: 10px;
        }
        .upload-container input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 400;
            margin-bottom: 20px;
        }
        .upload-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 4px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h1>Social Media Usage and Emotional Well-Being 📱</h1>
        <p>Upload file Dataset</p>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="berkas" />
            <input type="submit" name="upload" value="Upload" />
        </form>
        <div class="result">
            <?php 
            function panggil_model() {
                $perintah = "python social_media.py";
                $output = shell_exec($perintah); 
                // return "$output"; 
            }

            if(isset($_POST["upload"])) {
                // Ambil data file
                $namaFile = $_FILES['berkas']['name'];
                $namaSementara = $_FILES['berkas']['tmp_name'];

                // Tentukan lokasi file akan dipindahkan
                $dirUpload = "dataset/";

                // Pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

                if ($terupload) {
                    echo "Upload berhasil!<br/>";
                    echo "<a class='btn' href='".$dirUpload.$namaFile."' download>Download Dataset</a><br/>";
                    $hasil = shell_exec("python social_media.py");
                    echo 'Hasil prediksi: '.$hasil.'<br/>';
                    echo "<a class='btn' href='hasil/hasil.csv' download>Download Hasil</a><br/>";
                } else {
                    echo "Upload Gagal!";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

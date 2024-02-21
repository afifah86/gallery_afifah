<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Foto</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
</head>

<body>

    <div class="flex">
        <div class="flex flex-col fixed justify-between py-6 shadow-lg px-16 text-lg font-bold border-r border-black gap-6 h-screen">
            <div class="flex flex-col gap-3">
                <div class="mx-6">Gallery</div>
                <a href="index.php">Home</a>
                <a href="album.php">Album</a>
                <a href="foto.php">Foto</a>
            </div>
            <div class="flex">
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="ml-72 mr-20 my-12 w-full">
            <div class="mb-5">
                <p class="text-3xl">Selamat Datang <b><?= $_SESSION['namalengkap'] ?></b></p>
            </div>

            <div class="flex justify-center w-full mb-10">
                <form action="tambah_foto.php" method="post" enctype="multipart/form-data" class="w-2/3">
                    <div class="flex justify-center w-full mb-2">
                        <span class="text-2xl font-bold">Tambah Photo</span>
                    </div>
                    <div class="flex flex-col mb-2">
                        <span class="font-semibold">Judul Foto</span>
                        <input type="text" name="judulfoto" class="border border-black rounded-lg px-3 py-1">
                    </div>
                    <div class="flex flex-col mb-2">
                        <span class="font-semibold">Deskripsi Foto</span>
                        <!-- <input type="text" name="deskripsi"> -->
                        <textarea name="deskripsifoto" class="border border-black rounded-lg px-3 py-3"></textarea>
                    </div>
                    <div class="flex flex-col mb-2">
                        <span class="font-semibold">Lokasi Foto</span>
                        <input type="file" name="lokasifile" class="border border-black rounded-lg px-3 py-1">
                    </div>
                    <div class="flex flex-col mb-2">
                        <span class="font-semibold">Album</span>
                        <select name="albumid" class="border border-black rounded-lg px-3 py-1">
                            <option value="">pilih album</option>
                            <?php
                            include "koneksi.php";
                            $userid = $_SESSION['userid'];
                            $sql = mysqli_query($conn, "select * from album where userid='$userid'");
                            while ($data = mysqli_fetch_array($sql)) {
                            ?>
                                <option value="<?= $data['albumid'] ?>"><?= $data['namaalbum'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex flex-col w-full justify-center">
                        <button type="submit" class="border border-green-600 text-green-600 font-semibold rounded-lg py-2 uppercase transition-all hover:bg-green-600 hover:text-white hover:scale-105">Tambah</button>
                    </div>
                </form>
            </div>
            <div class="columns-5">
                <?php
                include "koneksi.php";
                $userid = $_SESSION['userid'];
                $sql = mysqli_query($conn, "select * from foto,album where foto.userid='$userid' and foto.albumid=album.albumid");
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                    <div class="break-inside-avoid flex flex-col items-center border border-black p-2 mb-2 rounded-lg">
                        <span hidden><?= $data['fotoid'] ?></span>
                        <div class="flex justify-between w-full gap-1">
                            <span class="font-semibold"><?= $data['judulfoto'] ?></span>
                            <span><?= $data['namaalbum'] ?></span>
                        </div>
                        <img src="gambar/<?= $data['lokasifile'] ?>" width="200px">
                        <span class="italic text-gray-400"><?= $data['tanggalunggah'] ?></span>
                        <span>"<?= $data['deskripsifoto'] ?>"</span>
                        <div class="flex gap-2 mt-2">
                            <a href="edit_foto.php?fotoid=<?= $data['fotoid'] ?>">
                                <span class="material-symbols-outlined text-yellow-600 px-2 py-1 rounded-lg transition-all hover:scale-105">
                                    edit
                                </span>
                            </a>
                            <a href="hapus_foto.php?fotoid=<?= $data['fotoid'] ?>">
                                <span class="material-symbols-outlined text-red-600 px-2 py-1 rounded-lg transition-all hover:scale-105">
                                    delete
                                </span>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>
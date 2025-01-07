<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Article
    </button>

    <div class="row">
        <div class="table-responsive" id="article_data">
            
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label>Isi</label>
                        <textarea class="form-control" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    load_data();
    function load_data(hlm){
        $.ajax({
            url : "article_data.php",
            method : "POST",
            data : {
					            hlm: hlm
				           },
            success : function(data){
                    $('#article_data').html(data);
            }
        })
    } 

    $(document).on('click', '.halaman', function(){
    var hlm = $(this).attr("id");
    load_data(hlm);
    });
});
</script>

<?php
include "upload_foto.php";
// Proses Simpan Artikel
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';

    if ($_FILES['gambar']['name'] != '') {
        $upload = upload_foto($_FILES['gambar']);
        if ($upload['status']) {
            $gambar = $upload['message'];
        } else {
            echo "<script>alert('" . $upload['message'] . "');</script>";
            die;
        }
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if ($_FILES['gambar']['name'] == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            unlink("img/" . $_POST['gambar_lama']);
        }
        $stmt = $conn->prepare("UPDATE article SET judul = ?, isi = ?, gambar = ?, tanggal = ?, username = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO article (judul, isi, gambar, tanggal, username) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}

// Proses Hapus Artikel
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if ($_POST['gambar'] != '') {
        unlink("img/" . $_POST['gambar']);
    }
    $stmt = $conn->prepare("DELETE FROM article WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}
?>

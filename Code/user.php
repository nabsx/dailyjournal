<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>

    <div class="row">
        <div class="table-responsive" id="user_data">
            
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" class="form-control" name="foto">
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
            url: "user_data.php",
            method: "POST",
            data: {hlm: hlm},
            success: function(data){
                $('#user_data').html(data);
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

// Proses Simpan User
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $foto = '';

    if ($_FILES['foto']['name'] != '') {
        $upload = upload_foto($_FILES['foto']);
        if ($upload['status']) {
            $foto = $upload['message'];
        } else {
            echo "<script>alert('" . $upload['message'] . "');</script>";
            die;
        }
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if ($_FILES['foto']['name'] == '') {
            $foto = $_POST['foto_lama'];
        } else {
            unlink("img/" . $_POST['foto_lama']);
        }
        $stmt = $conn->prepare("UPDATE user SET username = ?, password = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $password, $foto, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO user (username, password, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $foto);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}

// Proses Hapus User
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if ($_POST['foto'] != '') {
        unlink("img/" . $_POST['foto']);
    }
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}
?>
<?php
require_once 'config/database.php';

$id = $_GET['id'];

$stmt_get = $conn->prepare("SELECT * FROM barang WHERE id = ?");
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$data = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $lokasi = $_POST['lokasi'];

    $stmt = $conn->prepare("UPDATE barang SET nama_barang=?, kategori=?, jumlah=?, harga=?, lokasi=? WHERE id=?");
    $stmt->bind_param("ssidsi", $nama, $kategori, $jumlah, $harga, $lokasi, $id);

    if ($stmt->execute()) {
        header("Location: index.php?status=updated");
    } else {
        echo "Gagal mengupdate: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Edit Data Barang</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>

                                <input type="text" name="nama_barang" class="form-control" 
                                       value="<?= htmlspecialchars($data['nama_barang']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Elektronik" <?= ($data['kategori'] == 'Elektronik') ? 'selected' : ''; ?>>Elektronik</option>
                                    <option value="Perabot" <?= ($data['kategori'] == 'Perabot') ? 'selected' : ''; ?>>Perabot</option>
                                    <option value="Alat Kantor" <?= ($data['kategori'] == 'Alat Kantor') ? 'selected' : ''; ?>>Alat Kantor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" 
                                       value="<?= $data['jumlah']; ?>" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" 
                                       value="<?= $data['harga']; ?>" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" 
                                       value="<?= htmlspecialchars($data['lokasi']); ?>" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<div class="container-fluid pt-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5"><span class="px-2">Data Produk</span></h2>
  </div>
  <div class="row px-xl-5">
    <div class="col-lg-12 mb-5">
      <a href="<?php echo site_url('produk/add/' . $idToko); ?>" class="btn btn-primary text-white py-2 px-4 mb-4">Tambah
        Produk</a>
      <table class="table table-bordered bg-white rounded-3 black-bordered-table text-black" style="color:black">
        <thead>
          <tr>
            <th class="text-center align-middle" scope="col">No</th>
            <th class="text-center align-middle" scope="col">Nama Produk</th>
            <th class="text-center align-middle" scope="col">Gambar</th>
            <th class="text-center align-middle" scope="col">Harga</th>
            <th class="text-center align-middle" scope="col">Stok</th>
            <th class="text-center align-middle" scope="col">Berat</th>
            <th class="text-center align-middle" scope="col">Deskripsi</th>
            <th class="text-center align-middle" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($produk as $val) { ?>
            <tr>
              <th class="text-center align-middle" scope="row"><?php echo $no; ?></th>
              <td class="text-center align-middle"><?php echo $val->namaProduk; ?></td>
              <td class="text-center align-middle"><img src="<?php echo base_url('assets/foto_produk/' . $val->foto); ?>"
                  width="150" height="110"></td>
              <td class="text-center align-middle"><?php echo $val->harga; ?></td>
              <td class="text-center align-middle"><?php echo $val->stok; ?></td>
              <td class="text-center align-middle"><?php echo $val->berat; ?></td>
              <td class="text-center align-middle"><?php echo $val->deskripsiProduk; ?></td>
              <td class="text-center align-middle">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <a href="<?php echo site_url('produk/get_by_id/' . $val->idProduk); ?>"> <button type="button"
                      class="btn btn-secondary">Edit</button></a>
                  <a href="<?php echo site_url('produk/deletelah/' . $val->idProduk) . '/' . $idToko; ?>"
                    onclick="return confirm('Yakin Akan Hapus Data Ini?')"><button type="button"
                      class="btn btn-secondary">Hapus</button></a>
                </div>
              </td>
            </tr>
            <?php $no++;
          } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
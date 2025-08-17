<div class="container-fluid pt-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5"><span class="px-2">Toko Anda</span></h2>
  </div>
  <div class="row px-xl-5">
    <div class="col-lg-12 mb-5">
      <a href="<?php echo site_url('toko/add/'); ?>" class="btn btn-primary text-white py-2 px-4 mb-4">Tambah Toko</a>
      <table class="table table-bordered bg-white rounded-3 black-bordered-table text-black" style="color:black">
        <thead>
          <tr>
            <th class="text-center align-middle" scope="col">No</th>
            <th class="text-center align-middle" scope="col">Nama Toko</th>
            <th class="text-center align-middle" scope="col">Logo</th>
            <th class="text-center align-middle" scope="col">Deskripsi</th>
            <th class="text-center align-middle" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($toko as $val) { ?>
            <tr>
              <th class="text-center align-middle" scope="row"><?php echo $no; ?></th>
              <td class="text-center align-middle"><?php echo $val->namaToko; ?></td>
              <td class="text-center align-middle"><img src="<?php echo base_url('assets/logo_toko/' . $val->logo); ?>"
                  width="150" height="110"></td>
              <td class="text-center align-middle"><?php echo $val->deskripsi; ?></td>
              <td class="text-center align-middle">
                <div class="btn-group text-center align-middle" role="group" aria-label="Basic example">
                  <a class="text-center align-middle"
                    href="<?php echo site_url('toko/get_by_id/' . $val->idToko); ?>"><button type="button"
                      class="btn btn-secondary bg-gray1">Edit</button></a>
                  <a class="text-center align-middle"
                    href="<?php echo site_url('produk/index/' . $val->idToko); ?>"><button type="button"
                      class="btn btn-secondary">Kelola Toko</button></a>
                  <a class="text-center align-middle"
                    href="<?php echo site_url('main/order_history_penjualan/' . $val->idToko); ?>"><button type="button"
                      class="btn btn-secondary">Riwayat Penjualan</button></a>
                  <a class="text-center align-middle" href="<?php echo site_url('toko/delete/' . $val->idToko); ?>"
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
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> List Data Alternatif</h4>
                    <a href="?page=alternatiftambah" class="btn btn-primary"><i class="mdi mdi-plus-circle"></i> Tambah</a>
                    <div class="table-responsive pt-3">
                    <table class="example table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            ID
                          </th>
                          <th>
                            Nama Alternatif
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $no = 1;
                          $q = mysqli_query($conn, "SELECT id, nama_alternatif FROM alternatif");
                          while($data=mysqli_fetch_array($q)){ ?>
                              <tr>
                                  <td><?= $no ?></td>
                                  <td><span class="badge badge-success"><?= $data['id'] ?></span></td>
                                  <td><?= !empty($data['nama_alternatif']) ? $data['nama_alternatif'] : '-' ?></td>
                                  <td>
                                      <a href="?page=alternatifedit&id=<?= $data['id'] ?>" class="btn btn-inverse-info btn-sm">ubah</a>
                                      <input type="button" class="btn btn-inverse-danger btn-sm" value="hapus" onclick="confirmationDelete('<?= $data['id'] ?>')">
                                  </td>
                              </tr>
                        <?php $no++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  function confirmationDelete(id) {
    if (confirm(`Anda yakin ingin menghapus data ${id} ?`)) {
      $.ajax({
          url: 'config/delete_record.php',
          tyle: 'post',
          data: { id, name: 'alternatif' },
          success: function(res) {
            document.location.reload(true);
          },
          error: function(err) {
              console.log(err)
          }
      })
    }
  }
</script>
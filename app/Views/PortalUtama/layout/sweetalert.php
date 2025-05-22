<script>
    function destroy() {
        event.preventDefault();
        var form = document.forms['actionDelete'];
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak dapat mengembalikkan data yang telah dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    function destroy2(id,tipe,nama) {
        event.preventDefault();
        var form = document.forms['actionDelete2_'+tipe+id];
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: tipe+' '+nama+' akan dihapus'+'<br>'+'Anda tidak dapat mengembalikkan data yang telah dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    $(document).ready(function () {
        <?php if (session()->getFlashdata('sukses')) { ?>
        Swal.fire(
            {
                title: 'Sukses',
                text: '<?= session()->getFlashdata('sukses'); ?>',
                icon: 'success',
                showConfirmButton: false,
                timer: 1700
            }
        )
        <?php } else if (session()->getFlashdata('gagal')) { ?>
        Swal.fire(
            {
                title: 'Gagal',
                text: '<?= session()->getFlashdata('gagal'); ?>',
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            }
        )
        <?php } ?>
    });
</script>
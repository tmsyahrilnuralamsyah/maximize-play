<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maximize Play</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Table CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container">
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#inputMemberBaru">Input Member Baru</button>
        
        <div class="modal fade" id="inputMemberBaru" tabindex="-1" aria-labelledby="inputMember" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputMember">Input Member Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route("tambahMember") }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="no_id" class="form-label">No ID</label>
                                <input type="text" id="no_id" name="no_id" class="form-control" placeholder="No ID" required/>
                            </div>
                            <div class="col">
                                <label for="nama" class="form-label">Nama Member</label>
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Member" required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required/>
                            </div>
                            <div class="col">
                                <label for="no_telp" class="form-label">No Telp</label>
                                <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="No Telp" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="upline" class="form-label">Upline</label>
                                <select class="form-select" id="upline" name="upline" required>
                                    @if ($upline->count() > 0)
                                        @foreach ($upline as $u)
                                            <option>{{ $u->no_id . " - " . $u->nama }}</option>
                                        @endforeach
                                    @else
                                        <option>Utama</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    
        <table class="table table-striped table-bordered" id="tablejs">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">No ID</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">No Telp</th>
                    <th class="text-center">Upline</th>
                    <th class="text-center">Downline 1</th>
                    <th class="text-center">Downline 2</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $m)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $m->no_id }}</td>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->alamat }}</td>
                        <td>{{ $m->no_telp }}</td>
                        <td>{{ $m->upline }}</td>
                        <td>{{ $m->downline1 }}</td>
                        <td>{{ $m->downline2 }}</td>
                        <td class="text-center px-4">
                            <a class="btn btn-warning my-1" style="color: white;" onclick="showModal({{ $m }})">Edit</a>

                            @if ($m->downline1 == null && $m->downline2 == null)
                                <form action="{{ route("hapusMember", $m->id) }}" method="post" class="d-inline">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger my-1 hapusdata">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editDataMember" tabindex="-1" aria-labelledby="editMember" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMember">Edit Data Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formEditMember" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="e_no_id" class="form-label">No ID</label>
                            <input type="text" id="e_no_id" name="no_id" class="form-control" placeholder="No ID" required/>
                        </div>
                        <div class="col">
                            <label for="e_nama" class="form-label">Nama Member</label>
                            <input type="text" id="e_nama" name="nama" class="form-control" placeholder="Nama Member" required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="e_alamat" class="form-label">Alamat</label>
                            <input type="text" id="e_alamat" name="alamat" class="form-control" placeholder="Alamat" required/>
                        </div>
                        <div class="col">
                            <label for="e_no_telp" class="form-label">No Telp</label>
                            <input type="text" id="e_no_telp" name="no_telp" class="form-control" placeholder="No Telp" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="e_upline" class="form-label">Upline</label>
                            <select class="form-select" id="e_upline" name="upline">
                                @foreach ($upline as $u)
                                    <option>{{ $u->no_id . " - " . $u->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <!-- Table JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#tablejs').DataTable({
                pageLength : 10,
                lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, 'all']],
            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        @if (session()->get('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session()->get('success') }}'
            })
        @elseif(session()->get('error'))
        Toast.fire({
                icon: 'error',
                title: '{{ session()->get('error') }}'
            })
        @endif

        function showModal(member){
            let modal = $('#editDataMember').modal('show')
            $('#e_no_id', modal).val(member['no_id'])
            $('#e_nama', modal).val(member['nama'])
            $('#e_alamat', modal).val(member['alamat'])
            $('#e_no_telp', modal).val(member['no_telp'])
            $('#e_upline', modal).val(member['upline'])
            console.log(member['downline1'])
            $('#formEditMember').attr('action', `/editMember/${member.id}`);
        }

        $('.hapusdata').click(function(event){
        var form =  $(this).closest("form");
        event.preventDefault();
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: 'Data tidak dapat dikembalikan setelah dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    })
    </script>
</body>
</html>
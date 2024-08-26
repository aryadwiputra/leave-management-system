@extends('layouts.dashboard')

@push('style')
    @include('style.datatable')
@endpush
@section('content')
    <div class="content-header">
        <div class="d-flex justify-content-between">
            <h4>Data Karyawan</h4>
            {{-- button add with modal --}}
            <a href="{{ route('dashboard.users.create') }}"
                class="btn d-sm-block d-md-block d-lg-block d-xl-block d-none btn-primary mb-2">
                Tambah Karyawan
            </a>
        </div>
        <a href="#" class="btn d-md-none d-lg-none d-xl-none d-block btn-primary mb-2">
            Tambah Karyawan
        </a>
    </div>


    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Posisi</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Tahun Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->department->name }}</td>
                            <td>{{ $user->position->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->join_year }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('dashboard.users.edit', $user->id) }}">Edit</a>
                                <button type="button" class="btn btn-danger" id="deleteBtn"
                                    onclick="deleteData({{ $user->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
@endsection


@push('script')
    @include('scripts.datatable')

    <script>
        $(function() {
            let table = $("#data-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
        });

        function deleteData(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikannya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('dashboard.users.destroy', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page after closing the alert
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                xhr.responseJSON.message ||
                                'Terjadi kesalahan saat menghapus pengguna.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endpush

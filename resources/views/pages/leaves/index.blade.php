@extends('layouts.dashboard')

@push('style')
    @include('style.datatable')
@endpush
@section('content')
    <div class="content-header">
        <div class="d-flex justify-content-between">
            <h4>Data {{ $type }}
                @if ($status == 'pending')
                    Menunggu Persetujuan
                @elseif ($status == 'rejected')
                    Ditolak
                @elseif ($status == 'approved')
                    Diterima
                @endif
            </h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- if success --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Leader</th>
                        <th>Tanggal</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Deskripsi</th>
                        @if ($type == 'izin' || $type == 'sakit')
                            <th>Tipe</th>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->leader->name }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->start }}</td>
                            <td>{{ $data->end }}</td>
                            <td>{{ $data->description }}</td>
                            @if ($type == 'izin' || $type == 'sakit')
                                <td>{{ ucfirst($data->type) }}</td>
                            @endif
                            <td>
                                @if ($data->status == 'pending')
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">{{ ucfirst($data->status) }}</button>
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="#"
                                                onclick="updateStatus('rejected')">Tolak</a>
                                            <a class="dropdown-item" href="#"
                                                onclick="updateStatus('approved')">Terima</a>
                                        </div>
                                    </div>
                                @elseif($data->status == 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @elseif($data->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @endif
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
    </script>

    @if ($leaves->isNotEmpty())
        // Pastikan data tidak kosong sebelum menjalankan script
        <script>
            function updateStatus(status) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dashboard.leaves.updateStatus', $data->id) }}',
                    data: {
                        _method: 'PUT',
                        id: '{{ $data->id }}',
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        </script>
    @else
        <script>
            console.warn('Tidak ada data untuk ditampilkan.');
        </script>
    @endif
@endpush

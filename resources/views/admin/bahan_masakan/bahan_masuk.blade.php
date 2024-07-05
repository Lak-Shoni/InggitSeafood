@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: '{{ session('success') }}',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                </script>
                            @endif
                            <h2>Tambah Bahan Masuk</h2>
                            <form action="{{ route('admin.bahan_masakan.store_bahan_masuk', $bahanMasakan->id) }}"
                                method="POST">
                                @csrf
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bahanMasuk">Jumlah Bahan Masuk</label>
                                        <input type="number" class="form-control" id="bahanMasuk" name="bahan_masuk"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalTransaksi">Tanggal Transaksi</label>
                                        <input type="date" class="form-control" id="tanggalTransaksi"
                                            name="tanggal_transaksi" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Tambah</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

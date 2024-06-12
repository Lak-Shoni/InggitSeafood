@extends('layout.admin')

@section('content')
<div class="ml-2">
    <h1>Inventories</h1>
    <a href="{{ route('admin.inventories.create') }}" class="btn btn-primary mb-4" >Add Inventory</a>
</div>
        
            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Kondisi</th>
                            <th>Tanggal Pembelian</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Tanggal Pembaruan Terakhir</th>
                            <th>Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->id }}</td>
                                    <td>{{ $inventory->nama_barang }}</td>
                                    <td>{{ $inventory->kategori }}</td>
                                    <td>{{ $inventory->jumlah }}</td>
                                    <td>{{ $inventory->satuan }}</td>
                                    <td>{{ $inventory->kondisi }}</td>
                                    <td>{{ $inventory->tanggal_pembelian }}</td>
                                    <td>{{ $inventory->harga_satuan }}</td>
                                    <td>{{ $inventory->total_harga }}</td>
                                    <td>{{ $inventory->tanggal_pembaruan_terakhir }}</td>
                                    <td>
                                        <a href="{{ route('admin.inventories.edit', $inventory->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.inventories.destroy', $inventory->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
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
            <!-- /.content -->

@endsection

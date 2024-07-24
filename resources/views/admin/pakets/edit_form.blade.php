<form id="formEditPaket" action="{{ route('admin.pakets.update', $paket->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-lg-6">
        <div class="form-group">
            <label for="jenis_paket">Jenis Paket</label>
            <select name="jenis_paket" class="form-control" required>
                <option value="">Pilih jenis</option>
                @foreach ($jenis as $data)
                    <option value="{{ $data->nama_jenis }}"
                        {{ $paket->jenis_paket == $data->nama_jenis ? 'selected' : '' }}>{{ $data->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nama_paket">Nama paket</label>
            <input type="text" name="nama_paket" class="form-control" value="{{ $paket->nama_paket }}" required>
        </div>
        <div class="form-group">
            <label for="gambar_paket">Gambar paket</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="gambar_paket">
                <label class="custom-file-label" for="customFile">Pilih file</label>
            </div>
            <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}" alt="{{ $paket->nama_paket }}"
                width="100">
        </div>
        <div class="form-group">
            <label for="isi_paket">Isi paket</label>
            <textarea name="isi_paket" class="form-control" required>{{ $paket->isi_paket }}</textarea>
        </div>
        <div class="form-group">
            <label for="harga_paket">Harga paket</label>
            <input type="number" name="harga_paket" class="form-control" value="{{ $paket->harga_paket }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>

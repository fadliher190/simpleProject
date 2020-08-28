
    {{-- form popup add barang --}}
    <div class="popup-tambah">
        <div class="outer" onclick="tutupPopupTambah()"></div>
        <div class="form-container">
            <div class="card">
                <div class="card-header text-primary font-weight-light">
                    <i class="fa fa-plus-circle"></i> Tambah Data Barang
                </div>
                <div class="card-body">
                    <div class="alert alert-danger w-100 " id="message" style="display: none">
                        <ul></ul>
                    </div>
                    <form class="form" id="form-tambah" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_barang">
                                <small>Nama Barang <span class="text-danger">*</span></small>
                            </label>
                            <input type="text" class="form-control font-weight-light" name="nama_barang" id="nama_barang">
                        </div>
                        <div class="form-group">
                            <label for="gambar_barang">
                                <small>File Gambar <span class="text-danger">*</span></small>
                            </label>
                            <input type="file" class="form-control font-weight-light" name="gambar_barang" id="gambar_barang">
                        </div>
                        <div class="form-group">
                            <label for="stok_barang">
                                <small>Stok <span class="text-danger">*</span></small>
                            </label>
                            <input type="number" class="form-control font-weight-light" name="stok_barang" id="stok_barang">
                        </div>
                        <button type="submit" class=" btn btn-primary float-right ml-2 font-weight-light" id="btnSubmitTambah"><i class="fa fa-save"></i> Simpan</button>
                        <a href="#" class="btn btn-danger float-right font-weight-light" id="btnBatal" onclick="tutupPopupTambah()"><i class="fa fa-times"></i> Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end form popup add barang --}}
<form id="chart" class="row mb-3">
<div class="col-md-6">
	<label class="f-w-600 m-r-5">Nama Komoditas</label>
    <select class="uiselect" name="commodity">
    	<option value="">Pilih Komoditas</option>
       @foreach($commodity as $row)
       	<option value="{{ $row->id }}">{{ $row->nama_komoditas }}</option>
       @endforeach
    </select>
</div>
<div class="col-md-6 mb-3">
    <label>Mulai Dari (Tahun)</label>
    <input type="text" class="form-control" id="yearpicker" name="date" autocomplete="off">
</div>
<div class="d-flex flex-row-reverse form-group">
    <button class="btn btn-primary" type="submit">Cari</button>
</div>
</form>

<div class="row">
    <div class="col-lg-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Tambah Tanam (Ha)</h5>
            </div>
            <div class="card-body">
                <div id="chart-plant"></div>
            </div>
        </div>
    </div>
<!--     <div class="col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Luas Panen (Ha)</h5>
            </div>
            <div class="card-body">
                <div id="chart-harvest"></div>
            </div>
        </div>
    </div> -->
    <div class="col-lg-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Produksi (Ton)</h5>
            </div>
            <div class="card-body">
                <div id="chart-production"></div>
            </div>
        </div>
    </div>
</div>
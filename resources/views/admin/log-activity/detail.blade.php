<form class="theme-form" onsubmit="return false;">
    <div class="mb-3">
        <label class="form-label pt-0" for="user">User</label>
        <input class="form-control" id="user" name="user" type="text" value="{{ $data->user->no_hp }}" disabled />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="subject">Subjek</label>
        <input class="form-control" id="subject" name="subject" type="text" value="{{ $data->subject }}" disabled />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="url">URL</label>
        <input class="form-control" id="url" name="url" type="text" value="{{ $data->url }}" disabled />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="method">Method</label>
        <input class="form-control" id="method" name="method" type="text" value="{{ $data->method }}" disabled />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="ip">IP</label>
        <input class="form-control" id="ip" name="ip" type="text" value="{{ $data->ip }}" disabled />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="data_old">Data Lama</label>
        <textarea name="data_old" id="data_old" cols="30" rows="10" class="form-control" disabled>{{json_encode(json_decode($data->data_old), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)}}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="data_new">Data Baru</label>
        <textarea name="data_new" id="data_new" cols="30" rows="10" class="form-control" disabled>{{json_encode(json_decode($data->data_new), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)}}</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Kirim</button>
</form>
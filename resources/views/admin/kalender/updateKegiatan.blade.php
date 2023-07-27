<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="edit-modal-label">Edit Kegiatan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{ route('kegiatan.update', ['id' => $id]) }}">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <div class="form-group">
              <label for="start">Start</label>
              <input type="datetime-local" class="form-control" id="start" name="start" required>
            </div>

            <div class="form-group">
              <label for="end">End</label>
              <input type="datetime-local" class="form-control" id="end" name="end">
            </div>

            <input type="hidden" id="id" name="id">
            <input type="hidden" id="id_pegawai" name="id_pegawai" value="{{Auth::user()->id_pegawai}}">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Kegiatan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
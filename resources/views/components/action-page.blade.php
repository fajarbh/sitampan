@if($edit)
  <a href="{{ $edit }}" class="btn btn-xs btn-primary" ><i class="fa fa-pencil me-1"></i>Edit</a>
@endif

@if ($delete)
    <a href="#" onclick="deleteAlert('{{ $delete }}')" class="btn btn-xs btn-danger"><i class="fa fa-trash me-1"></i>Hapus</a>
@endif
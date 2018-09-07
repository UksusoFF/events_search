<a href="#tag-{{ $model['id'] or 'new' }}"
   class="{{ $type or 'badge' }} {{ $type or 'badge' }}-success"
   data-toggle="modal"><i class="fa fa-{{ $icon }}"></i>
</a>
<div id="tag-{{ $model['id'] or 'new' }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{ $action }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    @foreach([
                        'name',
                    ] as $field)
                        <div class="form-group">
                            <label for="tag-{{ $model['id'] or 'new' }}-{{ $field }}">{{ $field }}</label>
                            <input type="text"
                                   class="form-control"
                                   id="tag-{{ $model['id'] or 'new' }}-{{ $field }}"
                                   name="{{ $field }}"
                                   value="{{ $model[$field] or '' }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
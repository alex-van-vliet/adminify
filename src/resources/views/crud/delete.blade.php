@extends('adminify::app', [
    'title' => "{$model->getAdminTitle()} - Delete",
    'breadcrumb_title' => 'Delete',
    'breadcrumb' => [
        [route('adminify.index'), 'Index'],
        [route('adminify.crud.index', ['model' => $model->getTable()]), $model->getAdminTitle()],
        [route('adminify.crud.show', ['model' => $model->getTable(), 'object' => $object->getKey()]), $object->getKey()]
    ]
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body card-danger card-outline">
                        {{ $model->getAdminTitle(true) }} {{ $object->getKey() }} is going to be deleted.
                        <form method="POST"
                              action="{{ route('adminify.crud.destroy', ['model' => $model->getTable(), 'object' => $object]) }}">
                            @method('DELETE')

                            @csrf

                            <button type="submit" class="btn btn-danger">Delete</button>
                            <a href="javascript:history.back()" class="btn btn-outline-primary">Go back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

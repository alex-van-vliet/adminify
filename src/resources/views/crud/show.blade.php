@extends('adminify::app', [
    'title' => "{$model->getAdminTitle()} - Show",
    'breadcrumb_title' => $object->getKey(),
    'breadcrumb' => [
        [route('adminify.index'), 'Index'],
        [route('adminify.crud.index', ['model' => $model->getTable()]), $model->getAdminTitle()]
    ]
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <a href="{{ route('adminify.crud.create', ['model' => $model->getTable()]) }}"
                       class="btn btn-success"><i class="fa fa-plus"></i></a>
                    <a href="{{ route('adminify.crud.delete', ['model' => $model->getTable(), 'object' => $object->getKey()]) }}"
                       class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </div>
                <div class="card">
                    <div class="card-body card-primary card-outline">
                        <table id="example2" class="table table-bordered table-hover">
                            <tbody>
                            @foreach($fields as [$name, $accessor, $field])
                                <tr>
                                    <th>{{ $name }}</th>
                                    <td>{{ $object->{$accessor} }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

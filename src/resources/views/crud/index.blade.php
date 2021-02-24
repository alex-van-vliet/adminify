@extends('adminify::app', [
    'title' => $model->getAdminTitle(),
    'breadcrumb' => [
        [route('adminify.index'), 'Index']
    ]
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <a href="{{ route('adminify.crud.create', ['model' => $model->getTable()]) }}"
                       class="btn btn-success"><i class="fa fa-plus"></i></a>
                </div>
                <div class="card">
                    <div class="card-body card-primary card-outline">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                @foreach($fields as [$name, $accessor, $field])
                                    <th>{{ $name }}</th>
                                @endforeach
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($objects as $object)
                                <tr>
                                    @foreach($fields as [$name, $accessor, $field])
                                        <td>{{ $object->{$accessor} }}</td>
                                    @endforeach
                                    <td>
                                        <a href="{{ route('adminify.crud.show', ['model' => $model->getTable(), 'object' => $object->getKey()]) }}"
                                           class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('adminify.crud.delete', ['model' => $model->getTable(), 'object' => $object->getKey()]) }}"
                                           class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                @foreach($fields as [$name, $accessor, $field])
                                    <th>{{ $name }}</th>
                                @endforeach
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

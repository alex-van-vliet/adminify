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
                    <a href="{{ route('adminify.crud.create', ['model' => $model->getTable()]) }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
                </div>
                <div class="card">
                    <div class="card-body card-primary card-outline">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                @foreach($fields as [$name, $accessor, $field])
                                    <th>{{ $name }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($objects as $object)
                                <tr>
                                    @foreach($fields as [$name, $accessor, $field])
                                        <th>{{ $object->{$accessor} }}</th>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                @foreach($fields as [$name, $accessor, $field])
                                    <th>{{ $name }}</th>
                                @endforeach
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

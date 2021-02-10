@extends('adminify::app', [
    'title' => "{$model->getAdminTitle()} - Create",
    'breadcrumb_title' => 'Create',
    'breadcrumb' => [
        [route('adminify.index'), 'Index'],
        [route('adminify.crud.index', ['model' => $model->getTable()]), $model->getAdminTitle()]
    ]
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <form>
                        <div class="card-body">
                            @foreach($fields as [$name, $accessor, $field])
                                <div class="form-group">
                                    <label for="{{ $accessor }}">{{ $name }}</label>
                                    <input type="text" name="{{ $accessor }}" class="form-control" id="{{ $accessor }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

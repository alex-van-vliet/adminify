@extends('adminify::app', [
    'title' => "{$model->getAdminTitle()} - Edit",
    'breadcrumb_title' => 'Edit',
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
                <div class="card card-primary card-outline">
                    <form method="POST" action="">
                        @csrf

                        <div class="card-body">
                            @foreach($fields as $field)
                                @include($field->view(), ['field' => $field,
                                                          'name' => $field->getName(),
                                                          'accessor' => $field->getAccessor()])
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

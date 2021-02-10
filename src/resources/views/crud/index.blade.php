@extends('adminify::app', [
    'title' => $title,
    'breadcrumb' => [
        [route('adminify.index'), 'Index']
    ]
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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

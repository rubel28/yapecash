@extends('app')

@section('header')
    <style>
        .littleUp {
            margin-bottom: 2%;
        }

    </style>
@stop


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Amount
                </header>
                <div class="panel-body">
                    <div class="modal-body">

                        <div class="row">
                            {!! Form::open(['url'=>'services/'.$id.'/add_amount']) !!}
                            <div class="col-xs-6 pull-left">


                                <div class="form-group">
                                    {!! Form::label('amount','Amount') !!}
                                    {!! Form::text('amount',null,['class'=>'form-control','id'=>'myInput' ])!!}
                                </div>

                                <div class="form-group">
                                    <input type="radio" name="enable" checked value=1>enabled<br>
                                    <input type="radio" name="enable" value=0>disabled
                                </div>

                            </div>


                            <br/>

                            <div class="col-xs-12">
                                <div class="form-group col-xs-2">
                                    {!! Form::submit('Update',['class'=>'btn btn-primary form-control'])!!}
                                </div>
                            </div>

                        </div>

                        {!!Form::close() !!}
                    </div>
                </div>
                @include('errors.list')
            </section>
        </div>
    </div>

@stop

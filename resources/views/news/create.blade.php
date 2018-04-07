@extends('layouts.app')
@section('content') 



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                	<a href="{{url('news')}}" class="btn btn-primary">Back </a>
                	<br>
                    {!!Form::open(['url'=>'news','files'=>true])!!}
                        <div class="form-group">
                        {!!Form::label('title','Title')!!}
                        {!!Form::text('title',old('title'), ['class'=>'form-control'])!!}                            
                        </div>
                         <br>
                        <div class="form-group">
                        {!!Form::label('description','Description')!!}
                        {!!Form::textarea('description',old('description'), ['class'=>'form-control'])!!}                            
                        </div>
                        <br>
                         <div class="form-group">
                        {!!Form::label('photo','Photo')!!}
                        {!!Form::file('photo', ['class'=>'form-control'])!!}                            
                        </div>
                        <br>
                         <div class="form-group">
                        {!!Form::label('files','files')!!}
                        {!!Form::file('files[]', ['class'=>'form-control','multiple'=>'yes'])!!}                            
                        </div>
                        <br>
                        <div class="form-group">
                        {!!Form::label('content','Content')!!}
                        {!!Form::textarea('content',old('content'), ['class'=>'form-control'])!!}                            
                        </div>
                        <br>
                        {!!Form::submit('Add News',['class'=>'btn btn-success'])!!}


                    {!!Form::close()!!}
                	
                </div>
            </div>
        </div>
    </div>
</div>










@endsection
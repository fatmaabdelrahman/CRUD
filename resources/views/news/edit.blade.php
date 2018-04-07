@extends('layouts.app')
@section('content') 



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                	<a href="{{url('news')}}" class="btn btn-primary">back </a>
                	<br>
                    {!!Form::open(['url'=>'news/'.$news->id ,'files'=>true ,'method'=>'put'])!!}
                        <div class="form-group">
                        {!!Form::label('title','Title')!!}
                        {!!Form::text('title',$news->title, ['class'=>'form-control'])!!}                            
                        </div>
                         <br>
                        <div class="form-group">
                        {!!Form::label('description','Description')!!}
                        {!!Form::textarea('description',$news->description, ['class'=>'form-control'])!!}                            
                        </div>
                        <br>
                         <div class="form-group">
                        {!!Form::label('photo','Photo')!!}
                        {!!Form::file('photo', ['class'=>'form-control'])!!} 
                       
                        @if(!empty($news->photo))
                        <img src="{{url('Uploads/'.$news->photo)}}" style="width: 50px; height: 50px; ">    
                        @endif 

                        </div>
                        <br>
                         <div class="form-group">
                        {!!Form::label('files','files')!!}
                        {!!Form::file('files[]', ['class'=>'form-control','multiple'=>'yes'])!!}  

                        @foreach($news->files()->get() as $file)
                            <div class="col-md-4">
                                <label>
                                    <img src="{{url('Uploads/'.$file->file)}}" style="width: 50px; height: 50px; ">
                                    <input type="checkbox" name="file_id[]" value="{{$file ->id}}"/>
                                    <small>{{$file->file_name}}</small>
                                </label>
                            </div>
                        @endforeach

                        <div class='clearfix'></div>
                        @if ($news->files()->count() >0)
                         {!!Form::submit('delete photo',['class'=>'btn btn-danger', 'name'=>'delete_photo'])!!}
                         @endif
                        </div>
                        <br>

                        <div class="form-group">
                        {!!Form::label('content','Content')!!}
                        {!!Form::textarea('content',$news->content, ['class'=>'form-control'])!!}                            
                        </div>
                        <br>
                        {!!Form::submit('Save',['class'=>'btn btn-success'])!!}


                    {!!Form::close()!!}
                	
                </div>
            </div>
        </div>
    </div>
</div>










@endsection
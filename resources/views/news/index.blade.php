@extends('layouts.app')
@section('content') 



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8  col-md-offset-2">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                	<a href="{{url('news/create')}}" class="btn btn-primary">Add News </a>
                	<br>
                	<table class="table table-bordered table-hover">
                		<thead>
                            <tr>
                			<td>Title</td>
                            <td>AddBy</td>
                			<td>Photo</td>
                			<td>Description</td>
                			<td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                		@foreach($all_news as $news)
                		<tr>
                		  <td>{{$news->title}}</td>
                          <td>{{$news->addby->name}}</td>
                          <td><img src="{{url('Uploads/'.$news->photo)}}" style="width: 50px; height: 50px;"/></td>
                          <td>{{$news->description}}</td>
                          <td>
                            <a href="{{url('news/'.$news->id.'/edit')}}" class="btn btn-primary">Edit</a> 
                            {!!Form::open(['url'=>'news/'.$news->id,'method'=>'delete','style'=>'display:inline'])!!}
                                {!!Form::submit('delete',['class'=>'btn btn-danger'])!!}

                            {!!Form::close()!!}
                          </td>
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
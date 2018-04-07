<?php

namespace App\Http\Controllers;
use App\News;
use App\File;
use Storage;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_news=News::orderBy('id','desc')->paginate(10);
        $title ='News';
        return view('news.index',compact('all_news','title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title='create or Add News';
     return view('news.create',compact('title'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
          $rules=[
            'title'=>'required',
            'photo'=>'required|image',
            'files.*'=>'image',
            'description'=>'required',
            'content'=>'required'
        ];
            //
           $data= $this->validate(request(),$rules,[],[
             'title'=>'Title',
             'photo'=>'Photo',
             'description'=>'Description',
             'content'=>'Content'
        ]

        );
            //return $request->photo->store('images');
           $tempfolder= time();
           $data['photo']   = $request->photo->store('image/'.$tempfolder);
           $data['user_id'] = auth()-> user()->id ;
           
            $news=News::Create($data);
             if($request->hasFile('files')){
            foreach ($request-> file('files') as $file) {
               
                Storage::makeDirectory('image/'.$news->id);
                $uploadfile=$file->store('image/'.$news->id);
                
                File::Create([
                    'user_id'  =>  auth()-> user()->id,
                    'news_id'  =>  $news->id,
                    'path'     => 'image/'.$news->id,
                    'file'     =>  $uploadfile,
                    'file_name'=>  $file->getClientOriginalName(),
                    'size'     =>   Storage::size($uploadfile),

                ]);
            }}
            $newsname= str_replace($tempfolder,$news->id,$news['photo']);
            Storage::rename($news['photo'],$newsname);
            News::where('id',$news->id)->update(['photo'=>$newsname]); // move or rename tempfolder and save it
            Storage::deleteDirectory('image/'.$tempfolder); // delete directory temp

            session()->flash('success','News Add News successfully');
            return redirect('news');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $news= News::find($id);
        return view('news.edit',['news'=>$news,'title'=>'Edit News']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($request->has('delete_photo') and $request ->has('file_id'))
        {
            foreach ($request-> input('file_id') as $fid) 
            {
                    $file= File::find($fid);
                    Storage::delete($file->file);
                    $file->delete();
                    
             }     
            session()->flash('success','Photo is deleted');  
             return redirect('news/'.$id.'/edit');
        }else{
         $rules=[
            'title'=>'required',
            'photo'=>'image',
            'files.*'=>'image',
            'description'=>'required',
            'content'=>'required'
            ];
            //
           $data= $this->validate(request(),$rules,[],[
             'title'=>'Title',
             'photo'=>'Photo',
             'description'=>'Description',
             'content'=>'Content'
        ]

        );
            //return $request->photo->store('images');
           $data = request()->except(['files','_method','_token']);   
            $news           = News::find( $id);
            
            if($request->hasFile('photo'))
            {
           $data['photo']   = $request->photo->store('image/'.$id);}

           $data['user_id'] = auth()-> user()->id ;

           if($request->hasFile('files'))
           {
            foreach ($request-> file('files') as $file) {
               
                //Storage::makeDirectory('image/'.$news->id);
                $uploadfile=$file->store('image/'.$news->id);
                
                File::Create([
                    'user_id'  =>  auth()-> user()->id,
                    'news_id'  =>  $news->id,
                    'path'     => 'image/'.$news->id,
                    'file'     =>  $uploadfile,
                    'file_name'=>  $file->getClientOriginalName(),
                    'size'     =>   Storage::size($uploadfile),

                ]);
            }
        }
            News::where('id',$news->id)->update($data); // move or rename tempfolder and save it
        

            session()->flash('success','News Add News successfully');
            return redirect('news');


        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        News::find($id)->delete();
        session()->flash('success','News deleted successfully');
        Storage::deleteDirectory('image/'.$id);
         return redirect('news');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
class SlidersController extends Controller
{
    public function addSlider(){
        return view('admin.addSlider');
    }

    public function sliders(){
        $sliders = Slider::All();
        return view('admin.sliders')->with('sliders',$sliders);
    }

    public function createSlider(Request $request){
        $this->validate($request,['description1'=>'required'
                                , 'description2'=>'required' 
                                , 'sliderImage'=>'image|nullable|max:1999']);
        
        if($request->hasFile('sliderImage')){
            /* 1:Get file name with exte */
            $fileNameWithExt = $request->file('sliderImage')->getClientOriginalName();
            // 2: Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3:get just file extension
            $exstension = $request->file('sliderImage')->getClientOriginalExtension();
            // 4:File name store
            $fileNameToStore = $fileName.'_'.time().'.'.$exstension;

            //upload image
            $path = $request->file('sliderImage')->storeAs('public/sliderImages',$fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        $slider = new Slider();

        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        
        $slider->sliderImage = $fileNameToStore;
        $slider->status = 1;

        $slider->save();

        return back()->with('status','Product successfully created!');

    }


    public function editSlider($id){
        $slider = Slider::find($id);
        
        return view('admin.editSlider')->with('slider',$slider);
    }

    public function updateSlider(Request $request){
        $this->validate($request,['description1'=>'required'
                                , 'description2'=>'required'
                                
                                , 'sliderImage'=>'image|nullable|max:1999']);

            
        $slider = Slider::find($request->input('id'));
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        
        if($request->hasFile('sliderImage')){
         /* 1:Get file name with exte */
        $fileNameWithExt = $request->file('sliderImage')->getClientOriginalName();
         // 2: Get just file name
         $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);             
         // 3:get just file extension
        $exstension = $request->file('sliderImage')->getClientOriginalExtension();
         // 4:File name store
         $fileNameToStore = $fileName.'_'.time().'.'.$exstension;
                        
         //upload image
         $path = $request->file('sliderImage')->storeAs('public/sliderImages',$fileNameToStore);

         if($slider->sliderImage != 'noimage.jpg'){
            Storage::delete('public/sliderImages/'.$slider->sliderImage);  
         }

         $slider->sliderImage = $fileNameToStore;
        }

        
        
        

        $slider->update();

        return redirect('/sliders')->with('status','The Slider with ID:'.$slider->id.' has been successfully updated');
    }

    public function deleteSlider($id){
        $slider = Slider::find($id);
        if($slider->sliderImage != 'noimage.jpg'){
            Storage::delete('public/sliderImages/'.$slider->sliderImage);  
         }
        $slider->delete();

        return back()->with('status','The slider has been successfully deleted');
    }

    public function activateSlider($id){
        $slider = Slider::find($id);

        
            $slider->status = 1;
        

        $slider->update();
        return back();
    }

    public function unactivateSlider($id){
        $slider = Slider::find($id);

        
            $slider->status = 0;
        

        $slider->update();

        return back();
    }
}

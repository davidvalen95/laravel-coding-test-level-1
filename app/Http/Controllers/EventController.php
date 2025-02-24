<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Helper\Helper;
use App\Models\BaseModel;
use App\Models\EventModel;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use PHPUnit\TextUI\Help;

class EventController extends Controller{
    //




    public function get($id = null, $isActiveEventOnly = false){
        Cache::set('data','You have entered the event list');

        $response = EventModel::handleBasicGet($id, function($builder) use ($isActiveEventOnly){
            $name = request()->get('name');
            if($isActiveEventOnly){
                $builder->where('startAt', '<', now())->where('endAt', '>', now());
            }
            if($name){
                $builder->where('name','ilike',"%$name%");
            }
        });


        $response->controllerResponse = view('event.get');
        //# decide to return json on api or controller response  view
        //# no need populate the data get anymore on web view, data result handled in basic get
        return Helper::hybridResponse($response);


    }

    public function activeEvents(){


        return $this->get(null, true);
    }

    public function form($id = null){
        $response = new ApiResponse();


        $response->isSuccess = true;
        $response->message   = "Edit";
        if($id){
            $response->data->event = EventModel::findOrFail($id);

        }
        $response->controllerResponse = view('event.create');

        return Helper::hybridResponse($response);

    }

    public function handleRestful($id = null){



        //# restful by model base, more model no need to do 1 by 1 or worst copy paste, simple CRUD task
        $response = EventModel::handleBasicRestFull($id, function()use($id){
            $slugUnique = "unique:event,slug";
            if($id){
                $slugUnique.= ",$id"; //# ignore self update
            }
            \request()->validate([
                'endAt'   => 'required|after:startAt',
                'startAt' => 'required',
                'name'    => 'required',
                'slug'    => "required|$slugUnique",


            ]);
        });
        if($response->isSuccess && \request()->method() == "POST"){
//            $mail = new Mailable();
//            $mail->subject = "testing";
//            $mail->to =['email@gmail.com'];
//            $mail->html("SUccesss new event");
//            Mail::to("davidvalen95@gmail.com")->send($mail);
        }

        return Helper::hybridResponse($response);


    }
}

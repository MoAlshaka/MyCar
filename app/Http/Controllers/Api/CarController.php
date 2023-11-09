<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index(Request $request){
        $access_token = $request->bearerToken();
        $user=User::where('access_token',$access_token)->first();
        $cars= Car::where('user_id',$user->id)->get();
        return response()->json(CarResource::collection($cars));

    }

    public function show(Request $request,$id){
        $access_token = $request->bearerToken();
        $user=User::where('access_token',$access_token)->first();
        $car= Car::find($id);
        if(!$car){
            return response()->json(['message' => 'Car not found'], 404);
        }
        if ($user->id == $car->user_id ) {
            $car= new CarResource($car);
            return response()->json($car);
        }else {
            return response()->json(['message' => 'You do not have access to show this Car'], 403);
        }
    }

    public function store(Request $request){
        $access_token = $request->bearerToken();
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'year' => 'required',
            'phone' => 'required',
            'whatsapp' => 'required',
            'title' => 'required',
            'description' => 'required',
            'body_type' => 'required',
            'location' => 'required',
            'mileage' => 'required',
            'transmission' => 'required',
            'fuel' => 'required',
            'color' => 'required',
            'tags' => 'required',
            'price' => 'required',
            'doors' => 'required|integer',
            'cylinders' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response($errors, 400);
        }

        $image=$request->image;
        $ext=$image->getClientOriginalExtension();
        $new_name=uniqid() . '.' . $ext;
        $image->move(public_path('images/Cars'),$new_name);
        $user=User::where('access_token',$access_token)->first();
        $car=Car::create([
            'model'=>$request->model,
            'year'=>$request->year,
            'phone'=>$request->phone,
            'whatsapp'=>$request->whatsapp,
            'title'=>$request->title,
            'description'=>$request->description,
            'body_type'=>$request->body_type,
            'location'=>$request->location,
            'mileage'=>$request->mileage,
            'transmission'=>$request->transmission,
            'fuel'=>$request->fuel,
            'color'=>$request->color,
            'tags'=>$request->tags,
            'price'=>$request->price,
            'doors'=>$request->doors,
            'cylinders'=>$request->cylinders,
            'image'=>$new_name,
            'user_id'=>$user->id,
        ]);
        $data=[
            'id'=>$car->id,
            'model'=>$car->model,
            'year'=>$car->year,
            'phone'=>$car->phone,
            'whatsapp'=>$car->whatsapp,
            'title'=>$car->title,
            'description'=>$car->description,
            'body_type'=>$car->body_type,
            'location'=>$car->location,
            'mileage'=>$car->mileage,
            'transmission'=>$car->transmission,
            'fuel'=>$car->fuel,
            'color'=>$car->color,
            'tags'=>$car->tags,
            'price'=>$car->price,
            'doors'=>$car->doors,
            'cylinders'=>$car->cylinders,
            'image'=>"public/images/Cars/$car->image",
            'owner' => $car->user->name,
            'created_at'=>$car->created_at,
            'updated_at'=>$car->updated_at,
        ];

        return response()->json($data,201);
    }

    public function update(Request $request,$id){
        $access_token = $request->bearerToken();
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'year' => 'required',
            'phone' => 'required',
            'whatsapp' => 'required',
            'title' => 'required',
            'description' => 'required',
            'body_type' => 'required',
            'location' => 'required',
            'mileage' => 'required',
            'transmission' => 'required',
            'fuel' => 'required',
            'color' => 'required',
            'tags' => 'required',
            'price' => 'required',
            'doors' => 'required|integer',
            'cylinders' => 'required|integer',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $user = User::where('access_token', $access_token)->first();
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        if ($user->id == $car->user_id) {
            $image_name = $car->image;
            if ($request->hasFile('image')) {
                unlink(public_path("images/Cars/$image_name"));
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $image_name = uniqid() . '.' . $ext;
                $image->move(public_path('images/Cars'), $image_name);
            }
            $car->update([
                'model'=>$request->model,
                'year'=>$request->year,
                'phone'=>$request->phone,
                'whatsapp'=>$request->whatsapp,
                'title'=>$request->title,
                'description'=>$request->description,
                'body_type'=>$request->body_type,
                'location'=>$request->location,
                'mileage'=>$request->mileage,
                'transmission'=>$request->transmission,
                'fuel'=>$request->fuel,
                'color'=>$request->color,
                'tags'=>$request->tags,
                'price'=>$request->price,
                'doors'=>$request->doors,
                'cylinders'=>$request->cylinders,
                'image' => $image_name,

            ]);
            $updatedCar = Car::find($id);
            $data = [
                'id'=>$updatedCar->id,
                'model'=>$updatedCar->model,
                'year'=>$updatedCar->year,
                'phone'=>$updatedCar->phone,
                'whatsapp'=>$updatedCar->whatsapp,
                'title'=>$updatedCar->title,
                'description'=>$updatedCar->description,
                'body_type'=>$updatedCar->body_type,
                'location'=>$updatedCar->location,
                'mileage'=>$updatedCar->mileage,
                'transmission'=>$updatedCar->transmission,
                'fuel'=>$updatedCar->fuel,
                'color'=>$updatedCar->color,
                'tags'=>$updatedCar->tags,
                'price'=>$updatedCar->price,
                'doors'=>$updatedCar->doors,
                'cylinders'=>$updatedCar->cylinders,
                'image'=>"public/images/Cars/$updatedCar->image",
                'owner' => $updatedCar->user->name,
                'created_at'=>$updatedCar->created_at,
                'updated_at'=>$updatedCar->updated_at,
            ];
            return response()->json($data);
        } else {
            return response()->json(['message' => 'You do not have access to update this Car'], 403);
        }
    }

    public function delete(Request $request,$id){
        $access_token = $request->bearerToken();
        $user = User::where('access_token', $access_token)->first();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        if ($user->id == $car->user_id) {
            $imagePath = public_path("images/Cars/{$car->image}");

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $car->delete();
            return response()->json(['message' => 'Car deleted successfully']);
        } else {
            return response()->json(['message' => 'You do not have access to delete this Car'], 403);
        }
    }
}

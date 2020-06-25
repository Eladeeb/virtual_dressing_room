<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User ;
use App\Http\Resources\UserResource;
use Hash;
class UserController extends Controller
{
    public function update(Request $request)
    {

        $request->validate([
            'user_id'=>'required',
        ]);
        
        $data = $request->all();
        $user=User::find($data['user_id']);

        if(!empty($data['lat'])){
            $user->lat = $data['lat'];
        }
        if(!empty($data['district'])){
            $user->district = $data['district'];
        }
        if(!empty($data['commune'])){
            $user->commune = $data['commune'];
        }
        if(!empty($data['lan'])){
            $user->lan = $data['lan'];
        }
        if(!empty($data['first_name'])){
            $user->first_name = $data['first_nam'];
        }
        if(!empty($data['last_name'])){
            $user->last_name = $data['last_name'];
        }
        if(!empty($data['email'])){
            $user->email = $data['email'] ;
        }
        if(!empty($data['password'])){
            $user->password =Hash::make($data['password']);
        }
        if(!empty($data['phone'])){
            $user->phone = $data['phone'];
        }
        if(!empty($data['image'])){
            $user->image = $data['image'];
        }
        if(!empty($data['cover'])){
            $user->cover = $data['cover'];
        }
        if(!empty($data['ThreeD_model'])){
            $user->ThreeD_model = $data['ThreeD_model'];
        }
        if(!empty($data['city'])){
            $user->city = $data['city'];
        }
        if(!empty($data['village'])){
            $user->village = $data['village'];
        }

        $user->save();
        return new UserResource($user);

    }
}

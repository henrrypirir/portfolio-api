<?php

namespace Server\Http\Controllers;

use Server\User;
use Server\Developer;
use Server\Http\Resources\DeveloperResource;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{

    public function store(Request $request)
    {
      $label = $request->input('label');
      $phone = $request->input('phone');
      $website = $request->input('website');
      $summary = $request->input('summary');
      $address = $request->input('address');
      $region = $request->input('region');
      $country = $request->input('country');
      $username = $request->input('user.username');
      $email = $request->input('user.email');
      $password = bcrypt($request->input('user.password'));

      $user = new User;
      $user->name = $username;
      $user->email = $email;
      $user->password = $password;

      $developer = new Developer;
      $developer->label = $label;
      $developer->phone = $phone;
      $developer->website = $website;
      $developer->summary = $summary;
      $developer->address = $address;
      $developer->region = $region;
      $developer->country = $country;

      if($user->save() && $user->developer()->save($developer)){
        return new DeveloperResource($developer);
      }
    }


    public function show(Developer $developer)
    {
        $developer = Developer::findorfail($developer->id);
        return new DeveloperResource($developer);
    }


    // VALIDAR CON TOKEN SI ESTE PERTENECE AL USUARIO QUE SE DESEA ELIMINAR
    public function destroy(Developer $developer)
    {
      $developer = Developer::findorfail($developer->id);
      $developer->user->delete();
      return new DeveloperResource($developer);
    }
}

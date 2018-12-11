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
      if ($request->isMethod("PUT")) {
        // VALIDAR POR TOKEN QUE ESTE PERTENEZCA AL QUE QUIERE ACTUALIZAR
        $developer = Developer::findOrFail($request->id);
        $user = $developer->user;
      }else {
        $user = new User;
        $developer = new Developer;
      }

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

      $user->name = $username ? $username : $user->name;
      $user->email = $email ? $email : $user->email;
      $user->password = $password ? $password : $user->password;

      $developer->label = $label ? $label : $developer->label;
      $developer->phone = $phone ? $phone : $developer->phone;
      $developer->website = $website ? $website : $developer->website;
      $developer->summary = $summary ? $summary : $developer->summary;
      $developer->address = $address ? $address : $developer->address;
      $developer->region = $region ? $region : $developer->region;
      $developer->country = $country ? $country : $developer->country;

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

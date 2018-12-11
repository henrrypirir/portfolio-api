<?php

namespace Server\Http\Controllers;

use Server\User;
use Server\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }


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
        print("Usuario y Desarrollador guadado");
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Server\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function show(Developer $developer)
    {
        //
    }

    public function update(Request $request, Developer $developer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Server\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Developer $developer)
    {
        //
    }
}

<?php

namespace Server\Http\Controllers;

use Server\User;
use Server\Developer;
use Server\Http\Resources\DeveloperResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function __construct(Developer $developer)
    {
      $this->middleware('auth:api', ['except' => ['show'] ]);
    }

    public function store(Request $request)
    {
      try {

        if ($request->isMethod("PUT")) {
          // VALIDAR POR TOKEN QUE ESTE PERTENEZCA AL QUE QUIERE ACTUALIZAR
          $developer = Developer::where('user_id', $request->user()->id)->first();
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
      } catch (\Exception $e) {
        Log::critical("Could not create new developer: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["developer"=>"Something was wrong"], 500);
      }
    }


    public function show(Developer $developer)
    {
      try {
        $developer = Developer::findorfail($developer->id);
        return new DeveloperResource($developer);
      } catch (\Exception $e) {
        Log::critical("Could not show specific developer: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["developer"=>"Something was wrong"], 500);
      }

    }


    // VALIDAR CON TOKEN SI ESTE PERTENECE AL USUARIO QUE SE DESEA ELIMINAR
    public function destroy(Request $request, Developer $developer)
    {
      //developer del usuario == developer del Id enviado
      try {
        $developer_user = Developer::where('user_id', $request->user()->id)->first();
        if ($developer == $developer_user) {
          $developer->user->delete();
          return new DeveloperResource($developer);
        }
        return Response()->json(["developer"=>"You don't have permission to delete this developer"], 403);
      } catch (\Exception $e) {
        Log::critical("Could not delete developer: {$e->getCode()}, {$e->getLine()} , {$e->getMessage()}");
        return Response()->json(["developer"=>"Something was wrong"], 500);
      }

    }
}

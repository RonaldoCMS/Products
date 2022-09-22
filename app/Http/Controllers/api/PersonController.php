<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Http\Resources\PersonResource;
use App\Http\Requests\StorePersonRequest;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title=" OpenApi Documentation",
 *      description=" Swagger OpenApi description",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description=" API Server"
 * )
 *
 * @OA\Tag(
 *     name="Projects",
 *     description=" Api Endpoints"
 * )
 * @OA\Schemes(format="http")
 * @OAS\SecurityScheme(
 *      securityScheme="bearer_token",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class PersonController extends Controller
{
    /**
     * @OA\Get(
     *     path="/person",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function index()
    {
        $toReturn = json_encode(Person::all(), JSON_PRETTY_PRINT);
        return response($toReturn)->header('Content-Type', 'Application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        // $person = new Person();
        // $person->name = $request->name;
        // $person->surname = $request->surname;

        // $person->save();

        return new PersonResource(Person::create($request->all()));
    }


    public function show(Person $person)
    {
        $toReturn = json_encode($person, JSON_PRETTY_PRINT);
        //return response($toReturn)->header('Content-Type', 'Application/json');
        return new PersonResource($person);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person, Request $request) {
        $person->name = $request->name;
        $person->surname = $request->surname;

        $person->save();
        return $request;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $person->name = $request->name;
        $person->surname = $request->surname;

        $result = $person->save();

        return $person;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

        $barang = Person::where('id', $id)->get();

        if (!$barang->isEmpty()) {
            Person::where('id', $id)->delete();
            return response("", 200);
        } else {
            return response("", 400);
        }
    }
}

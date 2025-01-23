<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class CarController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    // return redirect('/car/create');

    $cars = User::find(1)
      ->cars()
      ->with(['primaryImage', 'maker', 'model'])
      ->orderBy('created_at', 'desc')
      ->paginate(5);


    return view('car.index', compact('cars'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('car.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->all();
    $featuresData = $data['features'];
    $images = $request->file('images') ?: [];

    $data['user_id'] = 1;
    $car = Car::create($data);

    $car->features()->create($featuresData);

    foreach ($images as $i => $image) {

      $path = $image->store('public/images');

      $car->images()->create(['image_path' => $path, 'position' => $i + 1]);
    }

    return redirect()->route('car.index');
  }


  /**
   * Display the specified resource.
   */
  public function show(Car $car)
  {
    if (!$car->published_at) {
      abort(404);
    }
    return view('car.show', compact('car'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Car $car)
  {
    return view('car.edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Car $car)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Car $car)
  {
    //
  }

  public function search(Request $request)
  {
    $maker = $request->integer('maker_id');
    $model = $request->integer('model_id');
    $carType = $request->integer('car_type_id');
    $fuelType = $request->integer('fuel_type_id');
    $state = $request->integer('state_id');
    $city = $request->integer('city_id');
    $yearFrom = $request->integer('year_from');
    $yearTo = $request->integer('year_to');
    $priceFrom = $request->integer('price_from');
    $priceTo = $request->integer('price_to');


    $sort = $request->input('sort', '-published_at') ?? "published_at";



    $mileage = $request->integer('mileage');


    $query = Car::where('published_at', '<', now())
      ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model']);



    if ($maker) {
      $query->where('maker_id', $maker);
    }
    if ($model) {
      $query->where('model_id', $model);
    }
    if ($state) {
      $query->join('cities', 'cities.id', '=', 'cars.city_id')
        ->where('cities.state_id', $state);
    }
    if ($city) {
      $query->where('city_id', $city);
    }
    if ($carType) {
      $query->where('car_type_id', $carType);
    }
    if ($fuelType) {
      $query->where('fuel_type_id', $fuelType);
    }
    if ($yearFrom) {
      $query->where('year', '>=', $yearFrom);
    }
    if ($yearTo) {
      $query->where('year', '<=', $yearTo);
    }
    if ($priceFrom) {
      $query->where('price', '>=', $priceFrom);
    }
    if ($priceTo) {
      $query->where('price', '<=', $priceTo);
    }
    if ($mileage) {
      $query->where('mileage', '<=', $mileage);
    }

    if (str_starts_with($sort, '-')) {
      $sortBy = substr($sort, 1);
      $query->orderBy($sortBy, 'desc');
    } else {
      $query->orderBy($sort);
    }

    $cars = $query->paginate(15)
      ->withQueryString();

    return view('car.search', ['cars' => $cars]);
  }

  public function watchlist()
  {
    // Find favourite cars for authenticated user
    // TODO We'll come back to this later
    $cars = User::find(9)
      ->favouriteCars()
      ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
      ->paginate(15);

    return view('car.watchlist', compact('cars'));
  }
}

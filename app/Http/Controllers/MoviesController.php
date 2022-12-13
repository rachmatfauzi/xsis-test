<?php

namespace App\Http\Controllers;

use App\Services\MoviesServices;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    private $moviesServices;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MoviesServices $moviesServices)
        {
//            $this->middleware('auth:api');
            $this->moviesServices = $moviesServices;
        }

    public function index(Request $request)
    {
        $param = [];
        if(isset($request->all()['search']))
            $param['search'] = $request->all()['search'];
        if(isset($request->all()['id']))
            $param['id'] = $request->all()['id'];

        $moviesServices = $this->moviesServices->fetchAll($param);
        if ($moviesServices)
            return $this->successRes($moviesServices, msgFetch(), 200);

        return $this->errorRes(msgNotFound('Movies'), 404);

    }

    public function showById($id)
    {

        $moviesServices = $this->moviesServices->fetchById($id);

        if ($moviesServices)
            return $this->successRes($moviesServices, msgFetch(), 200);

        return $this->errorRes(msgNotFound('Movies'), 404);

    }

    public function showBySAPid($id)
    {

        $moviesServices = $this->moviesServices->fetchBySAPid($id);

        if ($moviesServices)
            return $this->successRes($moviesServices, msgFetch(), 200);

        return $this->errorRes(msgNotFound('Movies'), 404);

    }

    public function postData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:225',
            'rating' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return $this->errorRes($validator->getMessageBag()->toArray());
        }
        $store = $this->moviesServices->postData($request);

        if($store){
            return $this->successRes($store, msgStored());
        }else{
            return $this->errorRes(msgNotStored());
        }
    }

    public function batchPostData(Request $request)
    {
        $data = $request->all();
        $store = $this->moviesServices->batchPostData($data);

        if($store){
            return $this->successRes($store, msgStored());
        }else{
            return $this->errorRes(msgNotStored());
        }
    }

    public function batchDeleteData(Request $request)
    {
        $data = $request->all();
        $store = $this->moviesServices->batchDeleteData($data);
        if($store){
            return $this->successRes($store, msgDeleted());
        }else{
            return $this->errorRes(msgNotDeleted());
        }
    }

    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required|string|max:225',
            'rating' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return $this->errorRes($validator->getMessageBag()->toArray());
        }
        $store = $this->moviesServices->updateData($request);

        if($store){
            return $this->successRes($request->all(), msgUpdated());
        }else{
            return $this->errorRes(msgNotUpdated());
        }
    }

    public function deleteData($id)
    {

        $moviesServices = $this->moviesServices->deleteData($id);

        if ($moviesServices)
            return $this->successRes($moviesServices, msgDeleted(), 200);

        return $this->errorRes(msgNotDeleted(), 404);

    }
}

<?php

namespace App\Services;

use App\Models\Movies;
use Illuminate\Support\Facades\DB;

class MoviesServices
{
    // index
    public function fetchAll($req)
    {
        return Movies::select('*')->where($req)->get();
    }

    // show by id
    public function fetchById($id)
    {
        return Movies::where('id', $id)->first();
    }

    public function postData($data)
    {
        try {
            return Movies::create([
                'title' => $data->title,
                'description' => $data->description,
                'rating' => $data->rating,
                'image' => $data->image
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function batchPostData($data)
    {
        try {
            return Movies::insert($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function batchDeleteData($data)
    {
        try {
            $movies = Movies::whereIn('id',$data);
            return $movies->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateData($data)
    {
        try {
            return DB::table('movies')
                ->where('id', $data->id)
                ->update([
                    'title' => $data->title,
                    'description' => $data->description,
                    'rating' => $data->rating,
                    'image' => $data->image
                ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteData($id)
    {
        try {
            return Movies::where('id', $id)->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
}

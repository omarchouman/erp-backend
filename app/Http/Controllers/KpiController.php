<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Kpi::with('employee')->paginate(10);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'level' => 'integer|min:1|max:100',
            'date' => 'required',
        ]);

        $inputs = $request->all();
        $kpi = new Kpi();
        $kpi->fill($inputs);
        $kpi->save();

        return response()->json([
           'message' => 'Kpi Created Successfully!',
           'kpi' => $kpi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Kpi::with('employee')->where('id', $id)->get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'level' => 'integer|min:1|max:100',
        ]);

        $inputs = $request->all();
        $kpi = Kpi::where('id', $id)->first();
        $kpi->update($inputs);

        return response()->json([
            'message' => 'Kpi Updated Successfully!',
            'employeekpi' => $kpi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Kpi::where('id', $id)->delete();

        return response()->json([
            'message' => 'Kpi Deleted Successfully!'
        ]);
    }
}

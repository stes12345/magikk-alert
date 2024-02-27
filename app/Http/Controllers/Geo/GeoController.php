<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\GeoFence;
use App\Http\Requests\StoreGeoFenceRequest;
use App\Http\Requests\UpdateGeoFenceRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\GeoFenceTrack;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;

class GeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //
        $geo = GeoFence::all();
        return view('geo_fence.list', ['geo' => $geo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        //
        return view('geo_fence.add');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGeoFenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGeoFenceRequest $request)
    {
        // Create a new instance of your model
        $geo = new GeoFence();

        // dd($request->all());

        // Assign values to the model attributes
        $geo->area_name = $request->input('area_name');
        //$geo->geom = $request->input('area_geom');
        $geo->created_by = $request->user()->id; // Assuming 'created_by' is a user ID

        // Save the record to the database
        $saveGeo = $geo->save();

        if($saveGeo) {
            $this->calculateGeo($geo->id,$request->input('area_geom'));
        }
        

        // Redirect to a view page
        return redirect()->route('geo-fence.index')->with('success', 'Record created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GeoFence  $geoFence
     * @return \Illuminate\Http\Response
     */
    public function show(GeoFence $geoFence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeoFence  $geoFence
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $geo = GeoFence::with('geoFenceTracks')->find($id);
        return view('geo_fence.add', ['geo' => $geo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGeoFenceRequest  $request
     * @param  \App\Models\GeoFence  $geoFence
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGeoFenceRequest $request, $id)
    {
        //
        $geo = GeoFence::findOrFail($id);

        // Update values to the model attributes
        $geo->area_name = $request->input('area_name');
        $geo->status = $request->input('status'); 

        // Save the record to the database
        $geo->save();

        return redirect()->route('geo-fence.index')->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeoFence  $geoFence
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeoFence $geoFence)
    {
        $geoFence->delete(); // Soft delete the item

        return redirect()->route('geo-fence.index')->with('success', 'Item deleted successfully.');
    }

    public function updateStatus(Request $request, GeoFence $geoFence)
    {
        $status = $request->status == 0 ? 1 : 0;
        $id = $request->id;
        // dd($status,$id);
        $geoFence->where(['id' => $id])->update(['status' => $status]);
        $finalStatus = $status == 0 ? 'Inactive' : 'Active';

        return redirect()->route('geo-fence.index')->with(['success' => 'Status updated successfully','status' => $finalStatus]);
    }

    public function calculateGeo($id, $geom = array()) {
       $geom = json_decode($geom, true);
    //    dd($geom[0]['lat']);
        foreach($geom as $k){
            $lat = $k['lat'];
            $long = $k['lng'];
            
            $data[] = [
                'latitude' => $lat, 
                'longitude' => $long, 
                'geom' => new Expression("ST_SetSRID(ST_MakePoint(".$lat.", ".$long."),4326)"), 
                'geo_fence_id' => $id
            ];
        }
        GeoFenceTrack::insert($data);
        $data1 = [
            'latitude' => $geom[0]['lat'], 
            'longitude' => $geom[0]['lng'], 
            'geom' => new Expression("ST_SetSRID(ST_MakePoint(".$geom[0]['lat'].", ".$geom[0]['lng']."),4326)"), 
            'geo_fence_id' => $id
        ];
        GeoFenceTrack::insert($data1);
            
        //ST_MakePolygon
        $geomSql = "
            SELECT ST_Multi(ST_MakePolygon(ST_MakeLine(geom))) as geom
            FROM (
                SELECT geom
                FROM tbl_geo_fence_track
                WHERE geo_fence_id = :insertId
            )";

        // Execute the query
        $geomRow = DB::select($geomSql, ['insertId' => $id]);

        // Convert the result to array
        $recgeom = json_decode(json_encode($geomRow), true);
        if($recgeom[0]['geom']){
            GeoFence::where('id', $id)
            ->update(['geom' => $recgeom[0]['geom']]);

            GeoFence::where('id', $id)
            ->update(['geom_area' => DB::raw('ROUND(ST_Area(geom::geography) / 1000)')]);
        }

    }
}

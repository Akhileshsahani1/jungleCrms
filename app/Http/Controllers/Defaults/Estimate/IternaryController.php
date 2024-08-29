<?php

namespace App\Http\Controllers\Defaults\Estimate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\Iternary;

class IternaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinations              = Destination::get();
        return view('defaults.estimates.iternies.iternies', compact('destinations'));
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
    public function store(Request $request)
    {
        $term           = new Destination;
        $term->state    = $request->state;
        $term->save();

        return redirect()->route('iternary.index')->with('success', 'Destination saved successully,');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $destination = Destination::find($id);
        $d_iternaries = DestinationIternary::where('destination_id',$id)->get();
         return view('defaults.estimates.iternies.show', compact('destination','d_iternaries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $destination = DestinationIternary::find($id);
            $d_iternaries = Iternary::where('destination_iternarie_id',$id)->get();
            return view('defaults.estimates.iternies.edit', compact('id','destination','d_iternaries'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $rules = [
            'name'           => 'required',
            'duration'           => 'required',
        ];

        $messages = [
            'name.required'      => 'Please enter the name.',
            'duration.required'  => 'Please Select the Duration.',
        ];

        $this->validate($request, $rules, $messages);

        $d_iternary                 = new DestinationIternary;
        $d_iternary->destination_id = $id;
        $d_iternary->name           = $request->name;
        $d_iternary->duration           = $request->duration;
        $d_iternary->save();

         if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){

               $item                  = new Iternary;
               $item->destination_iternarie_id      = $d_iternary->id;
               $item->title      = $value['title'];
               $item->text       = $value['text'];
               $item->save();

            }
        }
        return redirect()->route('iternary.index')->with('success', 'Iternaries added successully,');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Destination::find($id)->delete();
        return redirect()->route('iternary.index')->with('success', 'Destination deleted successully,');
    }
    public function deleteIternary($id){
        $Iternary = DestinationIternary::find($id);
        $Iternary->delete();
        return redirect()->route('iternary.show',$Iternary->destination_id)->with('success', 'Destination deleted successully,');

    }
    public function addIternary($id){
          
    return view('defaults.estimates.iternies.create', compact('id'));
    }
    public function updateIternary(Request $request, $id){
        $rules = [
            'name'           => 'required',
            'duration'       => 'required',
        ];

        $messages = [
            'name.required'      => 'Please enter the name.',
            'duration.required'  => 'Please Select the Duration.',
        ];

        $this->validate($request, $rules, $messages);
         $d_iternary                 = DestinationIternary::find($id);
         $d_iternary->name           = $request->name;
         $d_iternary->duration       = $request->duration;
         $d_iternary->save();

          Iternary::where('destination_iternarie_id',$id)->delete();
         if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){

               $item                  = new Iternary;
               $item->destination_iternarie_id      = $d_iternary->id;
               $item->title      = $value['title'];
               $item->text       = $value['text'];
               $item->save();

            }
        }
        return redirect()->route('iternary.show',$d_iternary->destination_id)->with('success', 'Iternaries Updated successully,');

    }
    public function getIternaries(Request $request){
      $iternaries = DestinationIternary::where('destination_id', $request->state)
      ->where('duration', $request->duration)
      ->get();

        $output = '';
        $output .= '<option></option>';
        foreach ($iternaries as $iternarie) {
            $output .= '<option value="' . $iternarie->id . '">' . $iternarie->name . '</option>';
        }
        return Response()->json($output);
    }
    public function showIternaries(Request $request){
         $iternaries = Iternary::where('destination_iternarie_id',$request->id)->get();
         $output = '<tbody>';
         $count = count($iternaries);
         foreach ($iternaries as $key => $item) {
            $output .= '<tr id="iternaries-option-row'. $key .'">
                                <td><input type="text" name="iternaries['. $key .'][title]"
                                        placeholder="Title" class="form-control"
                                        id="particular'. $key .'" required value="'. $item->title .'">
                                </td>';
              $output .= '<td><textarea name="iternaries['. $key .'][text]" placeholder="Text" class="form-control rate" required="">'. $item->text .'</textarea></td>';
            $output .= '<td class="text-right"><button type="button"
                                        onclick=$("#iternaries-option-row'. $key .'").remove();
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>';
        }
        $output .= '</tbody>';

        $output .= '<tfoot>
                    <tr>
                        <td class="text-right" colspan="6"><button type="button" onclick="addIternary();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>';
        $output1 = array(
           'output' => $output,
           'count'  => $count
        );
        return Response()->json($output1);
    }
}

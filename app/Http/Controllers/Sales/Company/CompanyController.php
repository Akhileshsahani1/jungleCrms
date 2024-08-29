<?php

namespace App\Http\Controllers\Sales\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\State;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->get();
        return view('sales.companies.list', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::get(['state']);
        return view('sales.companies.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'          => 'required',
            'email'         => 'required',
            'phone'         => 'required',
            'address_1'     => 'required',
            'address_2'     => 'required',
            'state'         => 'required',
            "websites"      => "required|array|min:1",
            "websites.*"    => "required|distinct|min:1",
        ]);

        $company            = new Company;
        $company->name      = $request->name;
        $company->email     = $request->email;
        $company->phone     = $request->phone;
        $company->address_1 = $request->address_1;
        $company->address_2 = $request->address_2;
        $company->state     = $request->state;
        $company->pincode   = $request->pincode;
        $company->gstin     = $request->gstin;
        $company->dark_color= $request->dark_color;
        $company->light_color= $request->light_color;
        $company->websites  = $request->websites;
         if($request->hasfile('image')){
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs('uploads/company/', $name, 'public');
            $company->logo = $name;

        }
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        $company->default = $company->default == 'yes' ? 'no': 'yes';
        $company->save();
        $othercompanies = Company::whereNotIn('id', [$id])->get();
        foreach($othercompanies as $othercompany){
            $other = Company::find($othercompany->id);
            if($company->default == 'yes'){
                $other->default = 'no';
            }else{
                $other->default = 'yes';
            }
            $other->save();
        }
        if($company->default == 'yes'){
            return redirect()->route('companies.index')->with('success', 'Selected Company is default now.');
        }else{
            return redirect()->route('companies.index')->with('error', 'Selected Company is removed from default now.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = State::get(['state']);
        $company = Company::find($id);
        $company->path = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo) : 'https://via.placeholder.com/150';
        return view('sales.companies.edit', compact('states', 'company'));
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
        $this->validate($request,[
            'name'          => 'required',
            'email'         => 'required',
            'phone'         => 'required',
            'address_1'     => 'required',
            'address_2'     => 'required',
            'state'         => 'required',
            "websites"      => "required|array|min:1",
            "websites.*"    => "required|distinct|min:1",
        ]);
        
        $company            = Company::find($id);
        $company->name      = $request->name;
        $company->email     = $request->email;
        $company->phone     = $request->phone;
        $company->address_1 = $request->address_1;
        $company->address_2 = $request->address_2;
        $company->state     = $request->state;
        $company->pincode   = $request->pincode;
        $company->gstin     = $request->gstin;
        $company->dark_color= $request->dark_color;
        $company->light_color= $request->light_color;
        $company->websites  = $request->websites;

        if($request->hasfile('image')){
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs('uploads/company/', $name, 'public');
            $company->logo = $name;

        }
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::find($id)->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully');
    }
}

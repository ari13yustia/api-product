<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\OrderQty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        dd($this->getModel("TR5003WNAI")['model']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getModel($inputData){
        $data = file_get_contents('https://api.appliance.io/test.json');
        $datajson = json_decode($data);

        foreach($datajson as $row) {
            $char1 = substr($row->model_number,0,4);
            $char2 = substr($row->model_number,-2);
            $chek = strpos($inputData, $char1);
            if($chek !== false){
                $chek2 = strpos($inputData, $char2);
                if($chek2 !== false){
                    $actual_data = ['model' => $row->model_number, 'category' => $row->category];
                    break;
                }else{
                    $actual_data = "";
                }
            }
        }

        return $actual_data;
    }

    public function store(Request $request)
    {

        $field = $request->validate([
            'no_invoice' => 'required',
            'model' => 'required',
            'ordered_qty' => 'required',
            'price' => 'required'
        ]);
        // $create = Inventory::create($field);

        $inputData = $field['model'];
        $getModel = $this->getModel($inputData);

        $create = new Inventory();
        $create->model = $getModel['model'];
        $create->category = $getModel['category'];
        $create->ordered_qty = $field['ordered_qty'];
        $create->current_qty = 0;
        $create->price = ($field['price'] * $field['ordered_qty'])/$field['ordered_qty'];
        $create->save();

        if($create){
            for($i = 0; $i < $create->ordered_qty; $i++){
                $createOrderedQty = new OrderQty();
                $createOrderedQty->no_invoice = $field['no_invoice'];
                $createOrderedQty->model = $create->model;
                $createOrderedQty->qty = 1;
                $createOrderedQty->price = $create->price;
                $createOrderedQty->save();
            }
            return response("success");
        }
    }

    public function addCurrentQty(Request $request)
    {
        $field = $request->validate([
            'model' => 'required',
            'qty' => 'required'
        ]);

        $inputData = $field['model'];
        $getModel = $this->getModel($inputData);

        $dataInv = Inventory::where('model',$getModel['model'])->first();
        if($dataInv->ordered_qty == 0 || $field['qty'] > $dataInv->ordered_qty) {
            return response("Data Ordered Kosong");
        }
        $dataInv->ordered_qty -= $field['qty'];
        $dataInv->current_qty += $field['qty'];
        $dataInv->price = ($field['qty'] * ($dataInv->ordered_qty - $field['qty']))/($dataInv->ordered_qty - $field['qty']);
        $dataInv->save();

        if($dataInv){
            for($i = 0; $i < $field['qty']; $i++){
                $createOrderedQty = OrderQty::where('model', $dataInv->model)->first();
                $createOrderedQty->delete();
            }
            return response("success");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

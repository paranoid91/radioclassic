<?php

namespace App\Http\Controllers\Admin;

use App\Billing;
use App\Http\Requests\BillingRequest;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;


class BillingsController extends Controller
{

    public $perms;

    /**
     * @var string
     */
    protected $moduleName= 'billings';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName,['check','pay'])]); // add billing permissions
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::select('id','short_desc','currency','merchant_id','account_id','page_id')->paginate(get_setting('pagination_num'));
        return view('admin.billings.index',compact('billings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.billings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillingRequest $request)
    {
        Billing::create($request->all());
        flash()->success(trans('all.entry_added'));
        return redirect(action('Admin\BillingsController@index'));
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
        $billing = Billing::findOrFail($id);
        return view('admin.billings.edit',compact('billing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillingRequest $request, $id)
    {
        $billing = Billing::findOrFail($id);
        $billing->update($request->all());
        flash()->success(trans('all.entry_updated'));
        return redirect(action('Admin\BillingsController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Billing::findOrFail($id)->delete();
        return trans('all.entry_removed');
    }

    public function check($bank_id,Request $request){
        $amount = $request->input('o_amount');
        $user_id = $request->input('o_uid');
        if($user_id > 0 && $amount > 0):
            $bank = Billing::findOrFail($bank_id);
            $amount = $amount * 100;
            return Response::view('admin.billings.payment.check',compact('bank','user_id','amount'))->header('Content-Type', 'text/xml');
        else:
            return Response::view('admin.billings.payment.error')->header('Content-Type', 'text/xml');
        endif;
    }

    public function pay($bank_id,Request $request){
        $user_id = $request->input('o_uid');
        $amount = $request->input('o_amount') / 100;
        $item_id = $request->input('o_tid');
        $result_code = $request->input('result_code');
        $trx_id = $request->input('trx_id');
        if (($result_code==1)AND($user_id>0)):
            Payment::create(['user_id'=>$user_id,'item_id'=>$item_id,'transaction_id'=>$trx_id,'amount'=>$amount,'status'=>1,'currency'=>'GEL']);
            return Response::view('admin.billings.payment.register',compact('bank_id','user_id','amount','item_id','result_code','trx_id'))->header('Content-Type', 'text/xml');
        elseif($user_id && $item_id && $trx_id&&$amount):
            Payment::create(['user_id'=>$user_id,'item_id'=>$item_id,'transaction_id'=>$trx_id,'amount'=>$amount,'status'=>0,'currency'=>'GEL']);
            return Response::view('admin.billings.payment.register',compact('bank_id','user_id','amount','item_id','result_code','trx_id'))->header('Content-Type', 'text/xml');
        else:
            return Response::view('admin.billings.payment.register')->header('Content-Type', 'text/xml');
        endif;
    }
}

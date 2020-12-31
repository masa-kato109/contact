<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactForm;
use Illuminate\Support\Facades\DB;
use App\Services\CheckFormData;
use App\Http\Requests\StoreContactForm;



class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  //  $contacts = ContactForm::all();
  //クエリビルダー
    //フォーム「serch」からデータをもってくる。
    //dd($request);
    //クエリビルダ

    //$contacts = DB::table('contact_forms')
    //->select('id', 'your_name', 'title', 'created_at')
    //->orderBy('created_at', 'desc')//昇順　逆順はasc
    //->paginate(20);

        //検索フォーム
        $serch = $request->input('serch');
        $query = DB::table('contact_forms');

        //serchがなかったら
        if($serch !== null){
            $serch_split = mb_convert_kana($serch,'s');
            $serch_split2 = preg_split('/[\s]+/', $serch_split,-1,PREG_SPLIT_NO_EMPTY);

            foreach($serch_split2 as $value)
            {
                $query->where('your_name','like','%'.$value.'%');
            }
            };
        
        //$query = DB::table('contact_forms');
        $query->select('id', 'your_name', 'title', 'created_at');
        $query->orderBy('created_at', 'desc');
    //昇順　逆順はasc
        $contacts = $query->paginate(20);



    //dd($contacts);
      return view('contact.index', compact('contacts'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('contact.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactForm $request)
    {
        //$_POST['name']が$request
        $contact = new ContactForm;
        //インスタンス化　依存性注入。
        $contact->your_name = $request->input('your_name');//フォームのデータを持ってくる。
        $contact->title = $request->input('title');
        $contact->email = $request->input('email');
        $contact->url = $request->input('url');
        $contact->gender = $request->input('gender');
        $contact->age = $request->input('age');
        $contact->contact = $request->input('contact');
        //dd($your_name);
        $contact->save();

        return redirect('contact/index');
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
        $contact = ContactForm::find($id);//エロクワント、モデルを使ってデータを持ってくる


        $gender = CheckFormData::checkGender($contact);

        $age = CheckFormData::checkAge($contact);


        return view('contact.show', compact('contact','gender','age'));//compactでviewに変数を渡す。
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
        $contact = ContactForm::find($id);

        return view('contact.edit', compact('contact'));
        
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
        //$contact = new ContactForm;
        //インスタンス化　依存性注入。
        $contact = ContactForm::find($id);//もともとあるインスタンスを持ってくる。

        $contact->your_name = $request->input('your_name');//フォームのデータを持ってくる。
        $contact->title = $request->input('title');
        $contact->email = $request->input('email');
        $contact->url = $request->input('url');
        $contact->gender = $request->input('gender');
        $contact->age = $request->input('age');
        $contact->contact = $request->input('contact');
        //dd($your_name);
        $contact->save();

        return redirect('contact/index');
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
        $contact = ContactForm::find($id);
        $contact->delete();

        return redirect('contact/index');


    }
}

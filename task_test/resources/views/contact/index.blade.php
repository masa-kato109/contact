@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">This is index files</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="GET" action="{{ route('contact.create')}}">
                      <button type="submit" class="btn btn-primary">
                        New contact Form
                      </button>
                    </form>

                    <form method="GET" action=" {{route('contact.index')}}"class="form-inline my-2 my-lg-0">
                      <input class="form-control mr-sm-2" name="serch" type="search" placeholder="Search" aria-label="Search">
                      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>



                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">id</th>
                          <th scope="col">氏名</th>
                          <th scope="col">件名</th>
                          <th scope="col">登録日時</th>
                          <th scope="col">詳細</th>


                        </tr>
                      </thead>
                      <tbody>
                          @foreach($contacts as $contact)
                          <tr>
                            <th>{{$contact->id}}</th>
                            <td>{{$contact->your_name}}</td>
                            <td>{{$contact->title}}</td>
                            <td>{{$contact->created_at}}</td>
                            <td><a href="{{ route('contact.show', ['id' => $contact->id ]) }}">詳細見る</a></td><!-- Route内にidがある時のみ-->


                          </tr>
                          @endforeach

                      </tbody>
                    </table>
                    {{ $contacts->links() }}
                </div>
            </div>
        </div><!--col-md-8-->
    </div>
</div>
@endsection

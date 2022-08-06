@extends('layouts.admin')
@section('content')
<form action="{{route('administrator.polls.create')}}" method="post" enctype="multipart/form-data">
    @csrf
<div class="card text-black">

    <div class="card-header d-inline-flex justify-content-between bg-success text-white edit-article-card-header align-items-center">
        <div class="title_headbar">{{ $title }}</div>
        <div class="function_button">
            <button class="btn btn-success" type="submit" name="btn" value="zapisz">Zapisz</button>
            {{-- <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-zamknij">Zapisz i zamknij</a> --}}
            {{-- <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-nowy">Zapisz i nowy</a> --}}
            {{-- <button class="btn btn-success" type="submit" name="btn" value="zamknij">Zamknij</a> --}}
        </div>
    </div>
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger mb-0 mt-3">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @if ($errors->has('email'))
                @endif
            </div>
        @endif
    </div>
    <div class="d-flex align-items-center form-group edit-title mt-3 mx-1">
        <div class="col-6 d-flex pl-0 align-items-center">
            <label class="p-2 mb-0">Pytanie:</label>
            <input id="jform_title" class="form-control" type="text" name="title" value="{{ old('title') }}"/>
        </div>
    </div>
    <div class="d-inline-flex edit-content pb-5">
        <div class="card-body p-0 col-9">
            <div class="card">
                <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="bologna-list" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tresc" role="tab" aria-controls="description" aria-selected="true">Odpowiedzi</a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content mt-3">
                        <div class="tab-pane active" id="tresc" role="tabpanel">
                            <div id="answer">
                                {{-- <div id="new_chq"></div> --}}
                                <div class="addremove">
                                    <div onclick="add()"><i class="fa-solid fa-circle-plus" style="color: rgb(0, 161, 67)"></i></div>
                                    <div onclick="remove()"><i class="fa-solid fa-circle-minus" style="color: #843534"></i></div>
                                </div>
                                <input type="hidden" value="0" id="total_chq">
                                <div class="form-group row m-0">
                                    <div class="form-group col-8">
                                        <label for="answer_0">Odpowiedź 1</label>
                                        <input type="text" class="form-control" value="" name="polls[answer_0]" id="answer_0">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="glosy_0">Głosy</label>
                                        <input type="number" class="form-control" value="0" name="polls[votes_0]" id="glosy_0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="control-group mb-3">
                <label for="stan" class="m-0">Stan</label>
                <select class="custom-select custom-select-sm flex-column" name="published">
                    <option selected value="1">Opublikowane</option>
                    <option value="0">Nie opublikowane</option>
                    <option value="2">Zarchiwizowane</option>
                    <option value="-2">W koszu</option>
                </select>
            </div>
        </div>
    </div>
    <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
    <input type="hidden" name="modified_by" value="0">
</form>
<script>
    $('#bologna-list a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
    function add(){
      var new_chq_no = parseInt($('#total_chq').val())+1;
      var iterator =  new_chq_no+1;
      var new_input="<div class='form-group row m-0' id=odpowiedz_"+new_chq_no+" row m-0><div class='form-group col-8'><label for='answer_"+new_chq_no+" '>Odpowiedź&nbsp;" +iterator+"</label><input type='text' class='form-control' value='' name='polls[answer_"+new_chq_no+"]' id=answer_"+new_chq_no+"></div><div class='form-group col-4'><label for='glosy_"+new_chq_no+"'>Głosy</label><input type='number' class='form-control' value='0' name='polls[votes_"+new_chq_no+"]' id=glosy_"+new_chq_no+"></div></div>"
      $('#answer').append(new_input);
      $('#total_chq').val(new_chq_no)
    }
    function remove(){
      var last_chq_no = $('#total_chq').val();
      console.log(last_chq_no);
      if(last_chq_no>0){
        $('#odpowiedz_'+last_chq_no).remove();
        $('#total_chq').val(last_chq_no-1);
      }
    }
</script>
@endsection

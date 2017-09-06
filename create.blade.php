@extends('scaffold-interface.layouts.app')
@section('title','Cadastrar Listening')
@section('content')

<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3>Cadastrar Listening</h3>
        </div>
        <div class="box-body">
            <div class="col-sm-11 ml-40">
                <form method = 'POST' action = '{!!url("/dashboard/activie")!!}' enctype="multipart/form-data">
                    <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input id="titulo" name = "titulo" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea cols=50 id="descricao" rows="6" name="descricao" maxlength="300" wrap="hard"class="form-control"></textarea>
                        {{--<input id="descricao" name = "descricao" type="text" class="form-control">--}}
                    </div>
                    <div class="form-group">
                        <label for="pdf">PDF</label>
                        <input id="pdf" name = "pdf" type="file" class="form-control" accept=".pdf" >
                    </div>
                    <div class="form-group">
                        <label>Subgrupo</label>
                        <select name = 'subgrupo_id' class = 'form-control'>
                            @foreach($subgrupos as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class = 'btn btn-success' type ='submit'>Cadastar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection